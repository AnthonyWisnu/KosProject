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

// Homepage
Route::get('/', [\App\Http\Controllers\Public\HomeController::class, 'index'])->name('home');

// Rooms
Route::get('/rooms', [\App\Http\Controllers\Public\RoomController::class, 'index'])->name('public.rooms.index');
Route::get('/rooms/{room}', [\App\Http\Controllers\Public\RoomController::class, 'show'])->name('public.rooms.show');

// Booking
Route::get('/booking/{room}', [\App\Http\Controllers\Public\BookingController::class, 'create'])->name('public.booking.create');
Route::post('/booking', [\App\Http\Controllers\Public\BookingController::class, 'store'])->name('public.booking.store');
Route::get('/booking-success/{booking}', [\App\Http\Controllers\Public\BookingController::class, 'success'])->name('public.booking.success');

// Contact
Route::get('/contact', [\App\Http\Controllers\Public\ContactController::class, 'index'])->name('public.contact');
Route::post('/contact', [\App\Http\Controllers\Public\ContactController::class, 'store'])->name('public.contact.store');

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

    // Ratings
    Route::resource('ratings', \App\Http\Controllers\Admin\RatingController::class)->only(['index', 'show', 'destroy']);

    // Settings
    Route::get('profile', [\App\Http\Controllers\Admin\ProfileKostController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [\App\Http\Controllers\Admin\ProfileKostController::class, 'update'])->name('profile.update');

    // User Management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::post('users/{user}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
});

/*
|--------------------------------------------------------------------------
| Tenant/Penyewa Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:penyewa'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/dashboard', [TenantDashboardController::class, 'index'])->name('dashboard');

    // Ratings
    Route::resource('ratings', \App\Http\Controllers\Tenant\RatingController::class);

    // Payments
    Route::get('payments', [\App\Http\Controllers\Tenant\PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/{payment}', [\App\Http\Controllers\Tenant\PaymentController::class, 'show'])->name('payments.show');
    Route::post('payments/{payment}/upload-proof', [\App\Http\Controllers\Tenant\PaymentController::class, 'uploadProof'])->name('payments.upload-proof');

    // Complaints
    Route::resource('complaints', \App\Http\Controllers\Tenant\ComplaintController::class)->only(['index', 'create', 'store', 'show']);

    // Profile
    Route::get('profile', [\App\Http\Controllers\Tenant\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [\App\Http\Controllers\Tenant\ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [\App\Http\Controllers\Tenant\ProfileController::class, 'updatePassword'])->name('profile.update-password');
});
