<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display tenant dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // Get active tenant record
        $activeTenant = $user->activeTenant;

        if (!$activeTenant) {
            return view('tenant.dashboard', [
                'activeTenant' => null,
                'room' => null,
                'latestPayment' => null,
                'recentPayments' => collect(),
                'recentComplaints' => collect(),
                'pendingPaymentsCount' => 0,
                'pendingComplaintsCount' => 0,
            ]);
        }

        // Load room with facilities and images
        $room = $activeTenant->load(['room.facilities', 'room.primaryImage']);

        // Get latest payment
        $latestPayment = Payment::where('tenant_id', $activeTenant->id)
            ->latest('payment_date')
            ->first();

        // Recent payments (last 5)
        $recentPayments = Payment::where('tenant_id', $activeTenant->id)
            ->latest('payment_date')
            ->take(5)
            ->get();

        // Recent complaints (last 5)
        $recentComplaints = Complaint::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Pending counts
        $pendingPaymentsCount = Payment::where('tenant_id', $activeTenant->id)
            ->where('status', 'pending')
            ->count();

        $pendingComplaintsCount = Complaint::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        return view('tenant.dashboard', compact(
            'activeTenant',
            'room',
            'latestPayment',
            'recentPayments',
            'recentComplaints',
            'pendingPaymentsCount',
            'pendingComplaintsCount'
        ));
    }
}
