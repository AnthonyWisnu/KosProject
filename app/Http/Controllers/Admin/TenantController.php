<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    /**
     * Display a listing of tenants
     */
    public function index(Request $request)
    {
        $query = Tenant::with(['user', 'room']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by room
        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $tenants = $query->latest()->paginate(15);
        $rooms = Room::all();

        return view('admin.tenants.index', compact('tenants', 'rooms'));
    }

    /**
     * Show the form for creating a new tenant
     */
    public function create()
    {
        $availableRooms = Room::where('status', 'tersedia')->get();
        $users = User::where('role', 'penyewa')
            ->whereDoesntHave('tenants', function ($q) {
                $q->where('status', 'active');
            })
            ->get();

        return view('admin.tenants.create', compact('availableRooms', 'users'));
    }

    /**
     * Store a newly created tenant
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_type' => 'required|in:existing,new',
            'user_id' => 'required_if:user_type,existing|exists:users,id',
            'name' => 'required_if:user_type,new|string|max:255',
            'email' => 'required_if:user_type,new|email|unique:users,email',
            'phone' => 'required_if:user_type,new|string|max:20',
            'password' => 'required_if:user_type,new|min:6',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,inactive',
            // Biodata fields
            'ktp' => 'required|string|max:20',
            'pekerjaan' => 'required|string|max:100',
            'alamat_asal' => 'required|string',
            'kontak_darurat_nama' => 'required|string|max:100',
            'kontak_darurat_telp' => 'required|string|max:20',
            'kontak_darurat_hubungan' => 'required|string|max:50',
        ], [
            'user_id.required_if' => 'User wajib dipilih',
            'name.required_if' => 'Nama wajib diisi',
            'email.required_if' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan',
            'phone.required_if' => 'Nomor telepon wajib diisi',
            'password.required_if' => 'Password wajib diisi',
            'room_id.required' => 'Kamar wajib dipilih',
            'start_date.required' => 'Tanggal mulai wajib diisi',
            'ktp.required' => 'Nomor KTP wajib diisi',
            'pekerjaan.required' => 'Pekerjaan wajib diisi',
            'alamat_asal.required' => 'Alamat asal wajib diisi',
            'kontak_darurat_nama.required' => 'Nama kontak darurat wajib diisi',
            'kontak_darurat_telp.required' => 'Telepon kontak darurat wajib diisi',
            'kontak_darurat_hubungan.required' => 'Hubungan kontak darurat wajib diisi',
        ]);

        DB::beginTransaction();
        try {
            // Create or get user
            if ($request->user_type === 'new') {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'role' => 'penyewa',
                    'email_verified_at' => now(),
                ]);
            } else {
                $user = User::find($request->user_id);
            }

            // Create tenant
            $biodata = [
                'ktp' => $request->ktp,
                'pekerjaan' => $request->pekerjaan,
                'alamat_asal' => $request->alamat_asal,
                'kontak_darurat_nama' => $request->kontak_darurat_nama,
                'kontak_darurat_telp' => $request->kontak_darurat_telp,
                'kontak_darurat_hubungan' => $request->kontak_darurat_hubungan,
            ];

            Tenant::create([
                'user_id' => $user->id,
                'room_id' => $request->room_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'biodata' => $biodata,
                'status' => $request->status,
            ]);

            // Update room status if tenant is active
            if ($request->status === 'active') {
                Room::find($request->room_id)->update(['status' => 'terisi']);
            }

            DB::commit();

            return redirect()->route('admin.tenants.index')
                ->with('success', 'Penghuni berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal menambahkan penghuni: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified tenant
     */
    public function show(Tenant $tenant)
    {
        $tenant->load(['user', 'room.facilities', 'payments']);
        return view('admin.tenants.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified tenant
     */
    public function edit(Tenant $tenant)
    {
        $availableRooms = Room::where('status', 'tersedia')
            ->orWhere('id', $tenant->room_id)
            ->get();
        $tenant->load(['user', 'room']);

        return view('admin.tenants.edit', compact('tenant', 'availableRooms'));
    }

    /**
     * Update the specified tenant
     */
    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,inactive',
            // Biodata fields
            'ktp' => 'required|string|max:20',
            'pekerjaan' => 'required|string|max:100',
            'alamat_asal' => 'required|string',
            'kontak_darurat_nama' => 'required|string|max:100',
            'kontak_darurat_telp' => 'required|string|max:20',
            'kontak_darurat_hubungan' => 'required|string|max:50',
        ]);

        DB::beginTransaction();
        try {
            $oldRoomId = $tenant->room_id;
            $oldStatus = $tenant->status;

            // Update biodata
            $biodata = [
                'ktp' => $request->ktp,
                'pekerjaan' => $request->pekerjaan,
                'alamat_asal' => $request->alamat_asal,
                'kontak_darurat_nama' => $request->kontak_darurat_nama,
                'kontak_darurat_telp' => $request->kontak_darurat_telp,
                'kontak_darurat_hubungan' => $request->kontak_darurat_hubungan,
            ];

            $tenant->update([
                'room_id' => $request->room_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'biodata' => $biodata,
                'status' => $request->status,
            ]);

            // Update old room status if room changed or status changed to inactive
            if ($oldRoomId != $request->room_id || ($oldStatus === 'active' && $request->status === 'inactive')) {
                $oldRoom = Room::find($oldRoomId);
                if ($oldRoom && !$oldRoom->activeTenant) {
                    $oldRoom->update(['status' => 'tersedia']);
                }
            }

            // Update new room status if active
            if ($request->status === 'active') {
                Room::find($request->room_id)->update(['status' => 'terisi']);
            }

            DB::commit();

            return redirect()->route('admin.tenants.index')
                ->with('success', 'Data penghuni berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal mengupdate penghuni: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified tenant
     */
    public function destroy(Tenant $tenant)
    {
        DB::beginTransaction();
        try {
            $roomId = $tenant->room_id;

            $tenant->delete();

            // Update room status
            $room = Room::find($roomId);
            if ($room && !$room->activeTenant) {
                $room->update(['status' => 'tersedia']);
            }

            DB::commit();

            return redirect()->route('admin.tenants.index')
                ->with('success', 'Penghuni berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus penghuni: ' . $e->getMessage());
        }
    }
}
