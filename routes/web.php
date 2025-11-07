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

    // Route lain untuk admin akan ditambahkan di phase berikutnya
    // Route::resource('rooms', RoomController::class);
    // Route::resource('facilities', FacilityController::class);
    // dll
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
