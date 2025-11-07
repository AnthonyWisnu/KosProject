<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComplaintController extends Controller
{
    /**
     * Display a listing of complaints
     */
    public function index(Request $request)
    {
        $query = Complaint::with(['user', 'room', 'respondedBy']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by room
        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        // Search by title or user name
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($qu) use ($request) {
                      $qu->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $complaints = $query->latest('created_at')->paginate(15);

        // Get rooms for filter
        $rooms = Room::orderBy('room_number')->get();

        // Get counts for summary
        $openCount = Complaint::where('status', 'open')->count();
        $inProgressCount = Complaint::where('status', 'in_progress')->count();
        $resolvedCount = Complaint::where('status', 'resolved')->count();
        $closedCount = Complaint::where('status', 'closed')->count();

        return view('admin.complaints.index', compact(
            'complaints',
            'rooms',
            'openCount',
            'inProgressCount',
            'resolvedCount',
            'closedCount'
        ));
    }

    /**
     * Display the specified complaint
     */
    public function show(Complaint $complaint)
    {
        $complaint->load(['user', 'room.images', 'respondedBy']);
        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Respond to complaint
     */
    public function respond(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
            'response' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $complaint->update([
                'status' => $validated['status'],
                'response' => $validated['response'],
                'responded_by' => auth()->id(),
                'responded_at' => now(),
            ]);

            DB::commit();

            // TODO: Send WhatsApp notification to user in future phase

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Respons berhasil dikirim'
                ]);
            }

            return redirect()->route('admin.complaints.index')
                ->with('success', 'Respons berhasil dikirim');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim respons: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal mengirim respons: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified complaint
     */
    public function destroy(Complaint $complaint)
    {
        try {
            // Only allow deletion of closed complaints
            if ($complaint->status !== 'closed') {
                return back()->with('error', 'Hanya keluhan dengan status closed yang bisa dihapus');
            }

            $complaint->delete();

            return redirect()->route('admin.complaints.index')
                ->with('success', 'Keluhan berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus keluhan: ' . $e->getMessage());
        }
    }
}
