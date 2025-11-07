<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments for the authenticated tenant.
     */
    public function index()
    {
        $tenant = auth()->user()->activeTenant;

        if (!$tenant) {
            return redirect()->route('tenant.dashboard')
                ->with('error', 'Anda belum memiliki kontrak aktif.');
        }

        $payments = Payment::where('tenant_id', $tenant->id)
            ->with('tenant.room')
            ->latest()
            ->paginate(10);

        return view('tenant.payments.index', compact('payments', 'tenant'));
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        $tenant = auth()->user()->activeTenant;

        // Check if payment belongs to this tenant
        if (!$tenant || $payment->tenant_id !== $tenant->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('tenant.payments.show', compact('payment'));
    }

    /**
     * Upload payment proof.
     */
    public function uploadProof(Request $request, Payment $payment)
    {
        $tenant = auth()->user()->activeTenant;

        // Check if payment belongs to this tenant
        if (!$tenant || $payment->tenant_id !== $tenant->id) {
            abort(403, 'Unauthorized action.');
        }

        // Validate upload
        $validated = $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Delete old proof if exists
        if ($payment->payment_proof && Storage::disk('public')->exists($payment->payment_proof)) {
            Storage::disk('public')->delete($payment->payment_proof);
        }

        // Store new proof
        $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        // Update payment
        $payment->update([
            'payment_proof' => $proofPath,
            'payment_status' => 'menunggu', // Set to pending verification
        ]);

        return redirect()->route('tenant.payments.show', $payment)
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }
}
