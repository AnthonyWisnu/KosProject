<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KostProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileKostController extends Controller
{
    /**
     * Show the form for editing the kost profile.
     */
    public function edit()
    {
        $profile = KostProfile::getProfile();
        return view('admin.profile.edit', compact('profile'));
    }

    /**
     * Update the kost profile in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $profile = KostProfile::getProfile();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($profile->logo && Storage::disk('public')->exists($profile->logo)) {
                Storage::disk('public')->delete($profile->logo);
            }

            // Store new logo
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }

        $profile->update($validated);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profil kost berhasil diperbarui.');
    }
}
