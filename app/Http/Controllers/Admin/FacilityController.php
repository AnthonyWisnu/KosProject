<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of facilities
     */
    public function index()
    {
        $facilities = Facility::withCount('rooms')->latest()->paginate(15);
        return view('admin.facilities.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new facility
     */
    public function create()
    {
        return view('admin.facilities.create');
    }

    /**
     * Store a newly created facility
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:facilities,name',
            'icon' => 'nullable|string|max:100',
        ], [
            'name.required' => 'Nama fasilitas wajib diisi',
            'name.unique' => 'Fasilitas ini sudah ada',
            'name.max' => 'Nama fasilitas maksimal 100 karakter',
        ]);

        Facility::create($validated);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified facility
     */
    public function edit(Facility $facility)
    {
        return view('admin.facilities.edit', compact('facility'));
    }

    /**
     * Update the specified facility
     */
    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:facilities,name,' . $facility->id,
            'icon' => 'nullable|string|max:100',
        ], [
            'name.required' => 'Nama fasilitas wajib diisi',
            'name.unique' => 'Fasilitas ini sudah ada',
            'name.max' => 'Nama fasilitas maksimal 100 karakter',
        ]);

        $facility->update($validated);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil diupdate');
    }

    /**
     * Remove the specified facility
     */
    public function destroy(Facility $facility)
    {
        // Check if facility is used by any room
        if ($facility->rooms()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus fasilitas yang masih digunakan oleh kamar');
        }

        $facility->delete();

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil dihapus');
    }
}
