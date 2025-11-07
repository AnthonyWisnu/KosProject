<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Tenant;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display financial report
     */
    public function financial(Request $request)
    {
        // Get filter parameters
        $year = $request->get('year', date('Y'));
        $month = $request->get('month');

        // Build payment query
        $paymentsQuery = Payment::with(['tenant.user', 'tenant.room'])
            ->where('status', 'verified')
            ->whereYear('payment_date', $year);

        if ($month) {
            $paymentsQuery->whereMonth('payment_date', $month);
        }

        $payments = $paymentsQuery->orderBy('payment_date', 'desc')->get();

        // Calculate statistics
        $totalIncome = $payments->sum('amount');
        $totalPayments = $payments->count();
        $averagePayment = $totalPayments > 0 ? $totalIncome / $totalPayments : 0;

        // Monthly income data for chart
        $monthlyIncome = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyIncome[$m] = Payment::where('status', 'verified')
                ->whereYear('payment_date', $year)
                ->whereMonth('payment_date', $m)
                ->sum('amount');
        }

        // Income by room type
        $incomeByRoomType = Payment::where('status', 'verified')
            ->whereYear('payment_date', $year)
            ->when($month, function($q) use ($month) {
                return $q->whereMonth('payment_date', $month);
            })
            ->join('tenants', 'payments.tenant_id', '=', 'tenants.id')
            ->join('rooms', 'tenants.room_id', '=', 'rooms.id')
            ->selectRaw('rooms.room_type, SUM(payments.amount) as total')
            ->groupBy('rooms.room_type')
            ->get();

        return view('admin.reports.financial', compact(
            'payments',
            'totalIncome',
            'totalPayments',
            'averagePayment',
            'monthlyIncome',
            'incomeByRoomType',
            'year',
            'month'
        ));
    }

    /**
     * Display occupancy report
     */
    public function occupancy(Request $request)
    {
        // Get total rooms
        $totalRooms = Room::count();

        // Get occupied rooms (with active tenants)
        $occupiedRooms = Room::where('status', 'terisi')->count();

        // Get available rooms
        $availableRooms = Room::where('status', 'tersedia')->count();

        // Get maintenance rooms
        $maintenanceRooms = Room::where('status', 'maintenance')->count();

        // Calculate occupancy rate
        $occupancyRate = $totalRooms > 0 ? ($occupiedRooms / $totalRooms) * 100 : 0;

        // Active tenants
        $activeTenants = Tenant::where('status', 'active')->count();

        // Inactive tenants
        $inactiveTenants = Tenant::where('status', 'inactive')->count();

        // Rooms with details
        $rooms = Room::with(['tenants' => function($q) {
            $q->where('status', 'active')->with('user');
        }])->orderBy('room_number')->get();

        // Occupancy by room type
        $occupancyByType = Room::selectRaw('room_type, status, COUNT(*) as count')
            ->groupBy('room_type', 'status')
            ->get()
            ->groupBy('room_type');

        return view('admin.reports.occupancy', compact(
            'totalRooms',
            'occupiedRooms',
            'availableRooms',
            'maintenanceRooms',
            'occupancyRate',
            'activeTenants',
            'inactiveTenants',
            'rooms',
            'occupancyByType'
        ));
    }

    /**
     * Export financial report to Excel
     */
    public function exportFinancialExcel(Request $request)
    {
        // TODO: Implement Excel export using Maatwebsite/Laravel-Excel
        // This will be implemented when the package is properly configured

        return back()->with('info', 'Fitur export Excel akan segera tersedia');
    }

    /**
     * Export financial report to PDF
     */
    public function exportFinancialPdf(Request $request)
    {
        // TODO: Implement PDF export using Barryvdh/Laravel-DomPDF
        // This will be implemented when the package is properly configured

        return back()->with('info', 'Fitur export PDF akan segera tersedia');
    }

    /**
     * Export occupancy report to Excel
     */
    public function exportOccupancyExcel(Request $request)
    {
        // TODO: Implement Excel export

        return back()->with('info', 'Fitur export Excel akan segera tersedia');
    }

    /**
     * Export occupancy report to PDF
     */
    public function exportOccupancyPdf(Request $request)
    {
        // TODO: Implement PDF export

        return back()->with('info', 'Fitur export PDF akan segera tersedia');
    }
}
