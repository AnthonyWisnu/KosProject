<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings
     */
    public function index(Request $request)
    {
        $query = Booking::with(['room']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by room
        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        // Search by guest name or email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('guest_name', 'like', '%' . $request->search . '%')
                  ->orWhere('guest_email', 'like', '%' . $request->search . '%')
                  ->orWhere('guest_phone', 'like', '%' . $request->search . '%');
            });
        }

        $bookings = $query->latest('created_at')->paginate(15);

        // Get rooms for filter
        $rooms = Room::orderBy('room_number')->get();

        // Get counts for summary
        $pendingCount = Booking::where('status', 'pending')->count();
        $confirmedCount = Booking::where('status', 'confirmed')->count();
        $cancelledCount = Booking::where('status', 'cancelled')->count();
        $completedCount = Booking::where('status', 'completed')->count();

        return view('admin.bookings.index', compact(
            'bookings',
            'rooms',
            'pendingCount',
            'confirmedCount',
            'cancelledCount',
            'completedCount'
        ));
    }

    /**
     * Display the specified booking
     */
    public function show(Booking $booking)
    {
        $booking->load(['room.images', 'room.facilities', 'payments']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update booking status
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $booking->update([
                'status' => $validated['status'],
                'notes' => $request->notes,
            ]);

            // If confirmed, optionally update room status
            if ($validated['status'] === 'confirmed') {
                // Room status can be managed separately in room management
                $message = 'Booking berhasil dikonfirmasi';
            } elseif ($validated['status'] === 'cancelled') {
                $message = 'Booking dibatalkan';
            } elseif ($validated['status'] === 'completed') {
                $message = 'Booking diselesaikan';
            } else {
                $message = 'Status booking diperbarui';
            }

            DB::commit();

            // TODO: Send WhatsApp notification in future phase

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->route('admin.bookings.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui status: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified booking
     */
    public function destroy(Booking $booking)
    {
        try {
            // Only allow deletion of cancelled or pending bookings
            if (!in_array($booking->status, ['pending', 'cancelled'])) {
                return back()->with('error', 'Hanya booking dengan status pending atau cancelled yang bisa dihapus');
            }

            $booking->delete();

            return redirect()->route('admin.bookings.index')
                ->with('success', 'Booking berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus booking: ' . $e->getMessage());
        }
    }
}
