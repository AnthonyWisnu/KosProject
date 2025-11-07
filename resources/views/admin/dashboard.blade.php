@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Message -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-lg shadow-lg p-6 text-white">
        <h2 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="mt-2 text-green-100">Berikut adalah ringkasan data kost Anda hari ini</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Kamar -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Kamar</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalRooms }}</p>
                </div>
            </div>
        </div>

        <!-- Kamar Terisi -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Kamar Terisi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $occupiedRooms }}</p>
                </div>
            </div>
        </div>

        <!-- Kamar Tersedia -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Kamar Tersedia</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $availableRooms }}</p>
                </div>
            </div>
        </div>

        <!-- Total Penghuni -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Penghuni</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $activeTenants }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Pending Payments -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Pembayaran Pending</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $pendingPayments }}</p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Bookings -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Booking Pending</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $pendingBookings }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Complaints -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Keluhan Pending</p>
                    <p class="text-3xl font-bold text-red-600">{{ $pendingComplaints }}</p>
                </div>
                <div class="bg-red-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Payments -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Pembayaran Terbaru</h3>
            </div>
            <div class="p-6">
                @if($recentPayments->count() > 0)
                <div class="space-y-4">
                    @foreach($recentPayments as $payment)
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 last:border-0">
                        <div>
                            <p class="font-medium text-gray-900">{{ $payment->tenant->user->name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500">Kamar: {{ $payment->tenant->room->room_number ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-400">{{ $payment->payment_date->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $payment->status === 'verified' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $payment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-center py-4">Belum ada pembayaran</p>
                @endif
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Booking Terbaru</h3>
            </div>
            <div class="p-6">
                @if($recentBookings->count() > 0)
                <div class="space-y-4">
                    @foreach($recentBookings as $booking)
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 last:border-0">
                        <div>
                            <p class="font-medium text-gray-900">{{ $booking->guest_name }}</p>
                            <p class="text-sm text-gray-500">Kamar: {{ $booking->room->room_number }}</p>
                            <p class="text-xs text-gray-400">{{ $booking->check_in_date->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $booking->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-center py-4">Belum ada booking</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Monthly Income -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Pendapatan Bulanan</h3>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <p class="text-sm text-gray-600">Pendapatan Bulan Ini</p>
                <p class="text-3xl font-bold text-green-600">Rp {{ number_format($currentMonthIncome, 0, ',', '.') }}</p>
            </div>
            <div class="mt-6">
                <p class="text-sm font-medium text-gray-700 mb-3">6 Bulan Terakhir</p>
                <div class="space-y-2">
                    @foreach($monthlyIncome as $income)
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600 w-20">{{ $income['month'] }}</span>
                        <div class="flex-1 mx-3">
                            <div class="bg-gray-200 rounded-full h-6">
                                <div class="bg-green-600 h-6 rounded-full flex items-center justify-end px-2"
                                     style="width: {{ $income['income'] > 0 ? min(($income['income'] / max(array_column($monthlyIncome, 'income'))) * 100, 100) : 0 }}%">
                                    <span class="text-xs text-white font-medium">{{ number_format($income['income'] / 1000000, 1) }}jt</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
