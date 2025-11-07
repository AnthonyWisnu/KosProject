@extends('layouts.tenant')

@section('title', 'Dashboard Penyewa')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Message -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-6 text-white">
        <h2 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="mt-2 text-blue-100">Berikut adalah informasi kamar dan aktivitas Anda</p>
    </div>

    @if($activeTenant)
    <!-- Room Information -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="md:flex">
            <!-- Room Image -->
            <div class="md:flex-shrink-0 md:w-1/3">
                @if($activeTenant->room->primaryImage)
                <img class="h-full w-full object-cover md:h-full md:w-full" src="{{ asset('storage/' . $activeTenant->room->primaryImage->image_path) }}" alt="Room {{ $activeTenant->room->room_number }}">
                @else
                <div class="h-64 md:h-full w-full bg-gray-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                @endif
            </div>
            <!-- Room Details -->
            <div class="p-8 md:w-2/3">
                <div class="uppercase tracking-wide text-sm text-blue-600 font-semibold">Kamar Saya</div>
                <h2 class="block mt-1 text-3xl leading-tight font-bold text-gray-900">Kamar {{ $activeTenant->room->room_number }}</h2>
                <p class="mt-2 text-gray-600">{{ $activeTenant->room->description }}</p>

                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Tipe</p>
                        <p class="text-lg font-semibold text-gray-900">{{ ucfirst($activeTenant->room->room_type) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Kapasitas</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $activeTenant->room->capacity }} Orang</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Harga</p>
                        <p class="text-lg font-semibold text-green-600">Rp {{ number_format($activeTenant->room->price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Mulai Menghuni</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $activeTenant->start_date->format('d M Y') }}</p>
                    </div>
                </div>

                <!-- Facilities -->
                @if($activeTenant->room->facilities->count() > 0)
                <div class="mt-6">
                    <p class="text-sm font-semibold text-gray-700 mb-3">Fasilitas:</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($activeTenant->room->facilities as $facility)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $facility->name }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Pending Payments -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Pembayaran Pending</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $pendingPaymentsCount }}</p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Complaints -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Keluhan Pending</p>
                    <p class="text-3xl font-bold text-red-600">{{ $pendingComplaintsCount }}</p>
                </div>
                <div class="bg-red-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Payment -->
    @if($latestPayment)
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Pembayaran Terakhir</h3>
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
            <div>
                <p class="text-sm text-gray-600">Tanggal Pembayaran</p>
                <p class="text-lg font-semibold text-gray-900">{{ $latestPayment->payment_date->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Jumlah</p>
                <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($latestPayment->amount, 0, ',', '.') }}</p>
            </div>
            <div>
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                    {{ $latestPayment->status === 'verified' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $latestPayment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $latestPayment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ ucfirst($latestPayment->status) }}
                </span>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Payment History -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Riwayat Pembayaran</h3>
            </div>
            <div class="p-6">
                @if($recentPayments->count() > 0)
                <div class="space-y-4">
                    @foreach($recentPayments as $payment)
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 last:border-0">
                        <div>
                            <p class="font-medium text-gray-900">{{ $payment->payment_date->format('d M Y') }}</p>
                            <p class="text-sm text-gray-500">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $payment->status === 'verified' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $payment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-center py-4">Belum ada riwayat pembayaran</p>
                @endif
            </div>
        </div>

        <!-- Complaint History -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Riwayat Keluhan</h3>
            </div>
            <div class="p-6">
                @if($recentComplaints->count() > 0)
                <div class="space-y-4">
                    @foreach($recentComplaints as $complaint)
                    <div class="pb-4 border-b border-gray-100 last:border-0">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $complaint->title }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ Str::limit($complaint->description, 50) }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $complaint->created_at->format('d M Y') }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $complaint->status === 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $complaint->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $complaint->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                {{ ucfirst($complaint->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-center py-4">Belum ada keluhan</p>
                @endif
            </div>
        </div>
    </div>

    @else
    <!-- No Active Tenant -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
        <svg class="mx-auto h-12 w-12 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <h3 class="mt-2 text-lg font-medium text-gray-900">Belum Ada Kamar Aktif</h3>
        <p class="mt-1 text-sm text-gray-500">Anda belum memiliki kamar yang aktif. Silakan hubungi admin untuk mendapatkan kamar.</p>
    </div>
    @endif
</div>
@endsection
