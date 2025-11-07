<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    /**
     * Display tenant's ratings
     */
    public function index()
    {
        $ratings = Rating::with(['room', 'user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('tenant.ratings.index', compact('ratings'));
    }

    /**
     * Show form to create rating
     */
    public function create(Request $request)
    {
        // Get tenant's active room
        $tenant = auth()->user()->activeTenant;

        if (!$tenant) {
            return redirect()->route('tenant.dashboard')
                ->with('error', 'Anda harus menjadi penghuni aktif untuk memberikan rating.');
        }

        $room = $tenant->room;

        // Check if already rated
        $existingRating = Rating::where('user_id', auth()->id())
            ->where('room_id', $room->id)
            ->first();

        if ($existingRating) {
            return redirect()->route('tenant.ratings.edit', $existingRating)
                ->with('info', 'Anda sudah memberikan rating untuk kamar ini. Anda dapat mengubahnya.');
        }

        return view('tenant.ratings.create', compact('room'));
    }

    /**
     * Store rating
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Check if user is tenant of this room
            $tenant = auth()->user()->activeTenant;
            if (!$tenant || $tenant->room_id != $validated['room_id']) {
                return back()->with('error', 'Anda hanya dapat memberikan rating untuk kamar yang Anda huni.');
            }

            // Check for duplicate
            $existing = Rating::where('user_id', auth()->id())
                ->where('room_id', $validated['room_id'])
                ->first();

            if ($existing) {
                return redirect()->route('tenant.ratings.index')
                    ->with('error', 'Anda sudah memberikan rating untuk kamar ini.');
            }

            Rating::create([
                'user_id' => auth()->id(),
                'room_id' => $validated['room_id'],
                'rating' => $validated['rating'],
                'review' => $validated['review'],
            ]);

            DB::commit();

            return redirect()->route('tenant.ratings.index')
                ->with('success', 'Rating berhasil ditambahkan. Terima kasih atas feedback Anda!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show form to edit rating
     */
    public function edit(Rating $rating)
    {
        // Check ownership
        if ($rating->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $room = $rating->room;
        return view('tenant.ratings.edit', compact('rating', 'room'));
    }

    /**
     * Update rating
     */
    public function update(Request $request, Rating $rating)
    {
        // Check ownership
        if ($rating->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $rating->update($validated);

        return redirect()->route('tenant.ratings.index')
            ->with('success', 'Rating berhasil diperbarui.');
    }

    /**
     * Delete rating
     */
    public function destroy(Rating $rating)
    {
        // Check ownership
        if ($rating->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $rating->delete();

        return redirect()->route('tenant.ratings.index')
            ->with('success', 'Rating berhasil dihapus.');
    }
}
