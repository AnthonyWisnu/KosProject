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
            'duration_months' => 'required|integer|min:1|max:12',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $room = Room::findOrFail($validated['room_id']);

            // Check room availability
            if ($room->status !== 'tersedia') {
                return back()->with('error', 'Maaf, kamar tidak tersedia.');
            }

            // Calculate check out date and total price based on duration in months
            $checkIn = Carbon::parse($validated['check_in_date']);
            $durationMonths = (int) $validated['duration_months'];
            $checkOut = $checkIn->copy()->addMonths($durationMonths);
            $totalPrice = $room->price * $durationMonths;

            // Create booking
            $booking = Booking::create([
                'room_id' => $validated['room_id'],
                'guest_name' => $validated['guest_name'],
                'guest_email' => $validated['guest_email'],
                'guest_phone' => $validated['guest_phone'],
                'check_in_date' => $checkIn->format('Y-m-d'),
                'check_out_date' => $checkOut->format('Y-m-d'),
                'duration_months' => $durationMonths,
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
