<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display all rooms
     */
    public function index(Request $request)
    {
        $query = Room::with(['images', 'facilities']);

        // Filter by room type
        if ($request->filled('type')) {
            $query->where('room_type', $request->type);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search by room number
        if ($request->filled('search')) {
            $query->where('room_number', 'like', '%' . $request->search . '%');
        }

        // Only show available rooms
        $query->where('status', 'tersedia');

        $rooms = $query->orderBy('room_number')->paginate(12);

        return view('public.rooms', compact('rooms'));
    }

    /**
     * Display room detail
     */
    public function show(Room $room)
    {
        $room->load(['images', 'facilities']);

        // Get similar rooms
        $similarRooms = Room::with(['images'])
            ->where('room_type', $room->room_type)
            ->where('id', '!=', $room->id)
            ->where('status', 'tersedia')
            ->limit(3)
            ->get();

        return view('public.room-detail', compact('room', 'similarRooms'));
    }
}
