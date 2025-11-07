<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Display a listing of complaints for the authenticated tenant.
     */
    public function index()
    {
        $tenant = auth()->user()->activeTenant;

        if (!$tenant) {
            return redirect()->route('tenant.dashboard')
                ->with('error', 'Anda belum memiliki kontrak aktif.');
        }

        $complaints = Complaint::where('tenant_id', $tenant->id)
            ->with('tenant.room')
            ->latest()
            ->paginate(10);

        return view('tenant.complaints.index', compact('complaints', 'tenant'));
    }

    /**
     * Show the form for creating a new complaint.
     */
    public function create()
    {
        $tenant = auth()->user()->activeTenant;

        if (!$tenant) {
            return redirect()->route('tenant.dashboard')
                ->with('error', 'Anda belum memiliki kontrak aktif.');
        }

        return view('tenant.complaints.create', compact('tenant'));
    }

    /**
     * Store a newly created complaint in storage.
     */
    public function store(Request $request)
    {
        $tenant = auth()->user()->activeTenant;

        if (!$tenant) {
            return redirect()->route('tenant.dashboard')
                ->with('error', 'Anda belum memiliki kontrak aktif.');
        }

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:rendah,sedang,tinggi',
        ]);

        $validated['tenant_id'] = $tenant->id;
        $validated['status'] = 'pending';

        Complaint::create($validated);

        return redirect()->route('tenant.complaints.index')
            ->with('success', 'Keluhan berhasil dikirim. Admin akan segera menanggapi.');
    }

    /**
     * Display the specified complaint.
     */
    public function show(Complaint $complaint)
    {
        $tenant = auth()->user()->activeTenant;

        // Check if complaint belongs to this tenant
        if (!$tenant || $complaint->tenant_id !== $tenant->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('tenant.complaints.show', compact('complaint'));
    }
}
