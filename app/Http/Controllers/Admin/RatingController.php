<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Room;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display all ratings
     */
    public function index(Request $request)
    {
        $query = Rating::with(['user', 'room']);

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by room
        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        // Search by user name
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $ratings = $query->latest()->paginate(15);

        // Get rooms for filter
        $rooms = Room::orderBy('room_number')->get();

        // Get statistics
        $averageRating = Rating::avg('rating');
        $totalRatings = Rating::count();
        $fiveStarCount = Rating::where('rating', 5)->count();
        $fourStarCount = Rating::where('rating', 4)->count();
        $threeStarCount = Rating::where('rating', 3)->count();
        $twoStarCount = Rating::where('rating', 2)->count();
        $oneStarCount = Rating::where('rating', 1)->count();

        return view('admin.ratings.index', compact(
            'ratings',
            'rooms',
            'averageRating',
            'totalRatings',
            'fiveStarCount',
            'fourStarCount',
            'threeStarCount',
            'twoStarCount',
            'oneStarCount'
        ));
    }

    /**
     * Display rating detail
     */
    public function show(Rating $rating)
    {
        $rating->load(['user', 'room.images']);
        return view('admin.ratings.show', compact('rating'));
    }

    /**
     * Delete rating
     */
    public function destroy(Rating $rating)
    {
        try {
            $rating->delete();

            return redirect()->route('admin.ratings.index')
                ->with('success', 'Rating berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus rating: ' . $e->getMessage());
        }
    }
}
