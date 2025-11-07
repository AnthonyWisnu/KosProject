<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Facility;
use App\Models\RoomImage;
use App\Models\PriceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class RoomController extends Controller
{
    /**
     * Display a listing of rooms
     */
    public function index(Request $request)
    {
        $query = Room::with(['images', 'facilities', 'activeTenant.user'])
            ->withCount('images');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by room type
        if ($request->filled('room_type')) {
            $query->where('room_type', $request->room_type);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('room_number', 'like', '%' . $request->search . '%');
        }

        $rooms = $query->latest()->paginate(15);

        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new room
     */
    public function create()
    {
        $facilities = Facility::all();
        return view('admin.rooms.create', compact('facilities'));
    }

    /**
     * Store a newly created room
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:20|unique:rooms,room_number',
            'room_type' => 'required|in:bulanan,harian',
            'capacity' => 'required|integer|min:1|max:10',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:tersedia,terisi,maintenance',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'room_number.required' => 'Nomor kamar wajib diisi',
            'room_number.unique' => 'Nomor kamar sudah digunakan',
            'room_type.required' => 'Tipe kamar wajib dipilih',
            'capacity.required' => 'Kapasitas wajib diisi',
            'price.required' => 'Harga wajib diisi',
            'status.required' => 'Status wajib dipilih',
            'images.max' => 'Maksimal 5 foto',
            'images.*.image' => 'File harus berupa gambar',
            'images.*.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'images.*.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        DB::beginTransaction();
        try {
            // Create room
            $room = Room::create([
                'room_number' => $validated['room_number'],
                'room_type' => $validated['room_type'],
                'capacity' => $validated['capacity'],
                'price' => $validated['price'],
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'],
            ]);

            // Attach facilities
            if ($request->has('facilities')) {
                $room->facilities()->attach($request->facilities);
            }

            // Upload images
            if ($request->hasFile('images')) {
                $this->uploadImages($room, $request->file('images'), $request->input('primary_image', 0));
            }

            DB::commit();

            return redirect()->route('admin.rooms.index')
                ->with('success', 'Kamar berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal menambahkan kamar: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified room
     */
    public function show(Room $room)
    {
        $room->load(['images', 'facilities', 'activeTenant.user', 'priceHistories.changedBy']);
        return view('admin.rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified room
     */
    public function edit(Room $room)
    {
        $facilities = Facility::all();
        $room->load(['images', 'facilities']);
        return view('admin.rooms.edit', compact('room', 'facilities'));
    }

    /**
     * Update the specified room
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:20|unique:rooms,room_number,' . $room->id,
            'room_type' => 'required|in:bulanan,harian',
            'capacity' => 'required|integer|min:1|max:10',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:tersedia,terisi,maintenance',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:room_images,id',
        ], [
            'room_number.required' => 'Nomor kamar wajib diisi',
            'room_number.unique' => 'Nomor kamar sudah digunakan',
            'room_type.required' => 'Tipe kamar wajib dipilih',
            'capacity.required' => 'Kapasitas wajib diisi',
            'price.required' => 'Harga wajib diisi',
            'status.required' => 'Status wajib dipilih',
        ]);

        DB::beginTransaction();
        try {
            // Track price change
            if ($room->price != $validated['price']) {
                PriceHistory::create([
                    'room_id' => $room->id,
                    'old_price' => $room->price,
                    'new_price' => $validated['price'],
                    'changed_by' => auth()->id(),
                ]);
            }

            // Update room
            $room->update([
                'room_number' => $validated['room_number'],
                'room_type' => $validated['room_type'],
                'capacity' => $validated['capacity'],
                'price' => $validated['price'],
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'],
            ]);

            // Sync facilities
            $room->facilities()->sync($request->facilities ?? []);

            // Delete selected images
            if ($request->has('delete_images')) {
                $this->deleteImages($request->delete_images);
            }

            // Upload new images
            if ($request->hasFile('images')) {
                $this->uploadImages($room, $request->file('images'), $request->input('primary_image'));
            }

            // Update primary image if specified
            if ($request->filled('set_primary')) {
                $this->setPrimaryImage($room, $request->set_primary);
            }

            DB::commit();

            return redirect()->route('admin.rooms.index')
                ->with('success', 'Kamar berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal mengupdate kamar: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified room
     */
    public function destroy(Room $room)
    {
        DB::beginTransaction();
        try {
            // Check if room has active tenant
            if ($room->activeTenant) {
                return back()->with('error', 'Tidak dapat menghapus kamar yang masih ditempati');
            }

            // Delete all images
            foreach ($room->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            $room->delete();

            DB::commit();

            return redirect()->route('admin.rooms.index')
                ->with('success', 'Kamar berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus kamar: ' . $e->getMessage());
        }
    }

    /**
     * Upload and process images
     */
    protected function uploadImages(Room $room, array $images, $primaryIndex = 0)
    {
        foreach ($images as $index => $image) {
            // Generate unique filename
            $filename = 'rooms/' . uniqid() . '_' . time() . '.jpg';

            // Process and save image
            $img = Image::read($image);
            $img->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->encode('jpg', 80);

            Storage::disk('public')->put($filename, $img);

            // Save to database
            RoomImage::create([
                'room_id' => $room->id,
                'image_path' => $filename,
                'is_primary' => ($index == $primaryIndex),
            ]);
        }
    }

    /**
     * Delete images
     */
    protected function deleteImages(array $imageIds)
    {
        $images = RoomImage::whereIn('id', $imageIds)->get();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
    }

    /**
     * Set primary image
     */
    protected function setPrimaryImage(Room $room, $imageId)
    {
        // Remove all primary flags
        $room->images()->update(['is_primary' => false]);

        // Set new primary
        RoomImage::where('id', $imageId)->update(['is_primary' => true]);
    }
}
