<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments
     */
    public function index(Request $request)
    {
        $query = Payment::with(['tenant.user', 'tenant.room', 'verifiedBy']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by month
        if ($request->filled('month')) {
            $query->whereMonth('payment_date', $request->month);
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->whereYear('payment_date', $request->year);
        }

        // Search by tenant name
        if ($request->filled('search')) {
            $query->whereHas('tenant.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $payments = $query->latest('payment_date')->paginate(15);

        // Get counts for summary
        $pendingCount = Payment::where('status', 'pending')->count();
        $verifiedCount = Payment::where('status', 'verified')->count();
        $rejectedCount = Payment::where('status', 'rejected')->count();

        // Total pending amount
        $pendingAmount = Payment::where('status', 'pending')->sum('amount');

        return view('admin.payments.index', compact(
            'payments',
            'pendingCount',
            'verifiedCount',
            'rejectedCount',
            'pendingAmount'
        ));
    }

    /**
     * Display the specified payment
     */
    public function show(Payment $payment)
    {
        $payment->load(['tenant.user', 'tenant.room', 'verifiedBy', 'booking']);
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Verify payment
     */
    public function verify(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'action' => 'required|in:verify,reject',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            if ($validated['action'] === 'verify') {
                $payment->update([
                    'status' => 'verified',
                    'verified_by' => auth()->id(),
                    'verified_at' => now(),
                    'notes' => $request->notes,
                ]);

                $message = 'Pembayaran berhasil diverifikasi';
            } else {
                $payment->update([
                    'status' => 'rejected',
                    'verified_by' => auth()->id(),
                    'verified_at' => now(),
                    'notes' => $request->notes,
                ]);

                $message = 'Pembayaran ditolak';
            }

            DB::commit();

            // TODO: Send WhatsApp notification in future phase

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->route('admin.payments.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memproses pembayaran: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Export payments to Excel
     */
    public function export(Request $request)
    {
        // TODO: Implement Excel export in future phase
        return back()->with('info', 'Fitur export akan segera tersedia');
    }
}
