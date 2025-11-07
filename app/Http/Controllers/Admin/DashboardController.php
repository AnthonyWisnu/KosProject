<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Complaint;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        // Statistics
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'tersedia')->count();
        $occupiedRooms = Room::where('status', 'terisi')->count();
        $activeTenants = Tenant::where('status', 'active')->count();

        // Pending items
        $pendingPayments = Payment::where('status', 'pending')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $pendingComplaints = Complaint::where('status', 'pending')->count();

        // Recent payments (last 5)
        $recentPayments = Payment::with(['tenant.user', 'tenant.room'])
            ->latest()
            ->take(5)
            ->get();

        // Recent bookings (last 5)
        $recentBookings = Booking::with('room')
            ->latest()
            ->take(5)
            ->get();

        // Monthly income (current month)
        $currentMonthIncome = Payment::where('status', 'verified')
            ->whereYear('payment_date', now()->year)
            ->whereMonth('payment_date', now()->month)
            ->sum('amount');

        // Last 6 months income for chart
        $monthlyIncome = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $income = Payment::where('status', 'verified')
                ->whereYear('payment_date', $date->year)
                ->whereMonth('payment_date', $date->month)
                ->sum('amount');

            $monthlyIncome[] = [
                'month' => $date->format('M Y'),
                'income' => $income
            ];
        }

        return view('admin.dashboard', compact(
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'activeTenants',
            'pendingPayments',
            'pendingBookings',
            'pendingComplaints',
            'recentPayments',
            'recentBookings',
            'currentMonthIncome',
            'monthlyIncome'
        ));
    }
}
