<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Show booking form
     */
    public function create(Room $room)
    {
        // Check if room is available
        if ($room->status !== 'tersedia') {
            return redirect()->route('public.rooms.index')
                ->with('error', 'Maaf, kamar tidak tersedia untuk booking.');
        }

        $room->load(['images', 'facilities']);

        return view('public.booking', compact('room'));
    }

    /**
     * Store booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $room = Room::findOrFail($validated['room_id']);

            // Check room availability
            if ($room->status !== 'tersedia') {
                return back()->with('error', 'Maaf, kamar tidak tersedia.');
            }

            // Calculate total price based on duration
            $checkIn = Carbon::parse($validated['check_in_date']);
            $checkOut = Carbon::parse($validated['check_out_date']);
            $duration = $checkIn->diffInDays($checkOut);
            $totalPrice = $room->price * $duration;

            // Create booking
            $booking = Booking::create([
                'room_id' => $validated['room_id'],
                'guest_name' => $validated['guest_name'],
                'guest_email' => $validated['guest_email'],
                'guest_phone' => $validated['guest_phone'],
                'check_in_date' => $validated['check_in_date'],
                'check_out_date' => $validated['check_out_date'],
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'notes' => $validated['notes'],
            ]);

            DB::commit();

            // TODO: Send confirmation email/WhatsApp

            return redirect()->route('public.booking.success', $booking)
                ->with('success', 'Booking berhasil! Kami akan segera menghubungi Anda untuk konfirmasi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Show booking success page
     */
    public function success(Booking $booking)
    {
        $booking->load(['room.images']);
        return view('public.booking-success', compact('booking'));
    }
}
