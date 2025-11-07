<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Tenant\DashboardController as TenantDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Homepage (public landing page - akan dibuat nanti)
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin/Pemilik Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pemilik'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Data Master
    Route::resource('rooms', \App\Http\Controllers\Admin\RoomController::class);
    Route::resource('facilities', \App\Http\Controllers\Admin\FacilityController::class);

    // Manajemen
    Route::resource('tenants', \App\Http\Controllers\Admin\TenantController::class);

    Route::resource('payments', \App\Http\Controllers\Admin\PaymentController::class)->only(['index', 'show']);
    Route::post('payments/{payment}/verify', [\App\Http\Controllers\Admin\PaymentController::class, 'verify'])->name('payments.verify');
    Route::get('payments/export', [\App\Http\Controllers\Admin\PaymentController::class, 'export'])->name('payments.export');

    Route::resource('bookings', \App\Http\Controllers\Admin\BookingController::class)->only(['index', 'show', 'destroy']);
    Route::post('bookings/{booking}/status', [\App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.status');

    Route::resource('complaints', \App\Http\Controllers\Admin\ComplaintController::class)->only(['index', 'show', 'destroy']);
    Route::post('complaints/{complaint}/respond', [\App\Http\Controllers\Admin\ComplaintController::class, 'respond'])->name('complaints.respond');

    // Reports
    Route::get('reports/financial', [\App\Http\Controllers\Admin\ReportController::class, 'financial'])->name('reports.financial');
    Route::get('reports/occupancy', [\App\Http\Controllers\Admin\ReportController::class, 'occupancy'])->name('reports.occupancy');
    Route::get('reports/financial/excel', [\App\Http\Controllers\Admin\ReportController::class, 'exportFinancialExcel'])->name('reports.financial.excel');
    Route::get('reports/financial/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'exportFinancialPdf'])->name('reports.financial.pdf');
    Route::get('reports/occupancy/excel', [\App\Http\Controllers\Admin\ReportController::class, 'exportOccupancyExcel'])->name('reports.occupancy.excel');
    Route::get('reports/occupancy/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'exportOccupancyPdf'])->name('reports.occupancy.pdf');

    // Routes lain akan ditambahkan di phase berikutnya
    // Route untuk settings, dll
});

/*
|--------------------------------------------------------------------------
| Tenant/Penyewa Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:penyewa'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/dashboard', [TenantDashboardController::class, 'index'])->name('dashboard');

    // Route lain untuk tenant akan ditambahkan di phase berikutnya
    // Route::get('/payments', [TenantPaymentController::class, 'index'])->name('payments');
    // Route::post('/payments', [TenantPaymentController::class, 'store'])->name('payments.store');
    // dll
});
