<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\KostProfile;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display homepage
     */
    public function index()
    {
        // Get featured rooms (available rooms)
        $featuredRooms = Room::with(['images', 'facilities'])
            ->where('status', 'tersedia')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Get kost profile
        $profile = KostProfile::first();

        // Get statistics
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'tersedia')->count();

        return view('public.home', compact('featuredRooms', 'profile', 'totalRooms', 'availableRooms'));
    }
}
