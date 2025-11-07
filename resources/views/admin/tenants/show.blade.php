@extends('layouts.admin')

@section('title', 'Detail Penghuni')
@section('page-title', 'Detail Penghuni')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $tenant->user->name }}</h2>
            <p class="text-gray-600 mt-1">Detail informasi penghuni</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.tenants.edit', $tenant) }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                Edit
            </a>
            <a href="{{ route('admin.tenants.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- User Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Pengguna</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-3xl font-semibold">
                            {{ substr($tenant->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">{{ $tenant->user->name }}</h4>
                            <p class="text-gray-600">{{ $tenant->user->email }}</p>
                            <p class="text-gray-600">{{ $tenant->user->phone }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Mulai</label>
                            <p class="text-sm font-medium text-gray-900">{{ $tenant->start_date->format('d M Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Selesai</label>
                            <p class="text-sm font-medium text-gray-900">{{ $tenant->end_date ? $tenant->end_date->format('d M Y') : 'Tidak ada batas' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Durasi</label>
                            <p class="text-sm font-medium text-gray-900">
                                @if($tenant->end_date)
                                    {{ $tenant->start_date->diffInDays($tenant->end_date) }} hari
                                @else
                                    {{ $tenant->start_date->diffInDays(now()) }} hari (ongoing)
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                {{ $tenant->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($tenant->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Biodata -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Biodata</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-4">
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Nomor KTP</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $tenant->biodata['ktp'] ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Pekerjaan</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $tenant->biodata['pekerjaan'] ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Alamat Asal</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $tenant->biodata['alamat_asal'] ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Kontak Darurat</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $tenant->biodata['kontak_darurat'] ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Payment History -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Riwayat Pembayaran</h3>
                </div>
                <div class="overflow-x-auto">
                    @if($tenant->payments->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tenant->payments as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $payment->payment_date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full
                                        @if($payment->status === 'verified') bg-green-100 text-green-800
                                        @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <a href="{{ route('admin.payments.show', $payment) }}" class="text-blue-600 hover:text-blue-900">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="text-center py-12">
                        <p class="text-gray-500">Belum ada riwayat pembayaran</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Room Info -->
        <div class="space-y-6">
            <!-- Room Card -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Kamar</h3>
                </div>
                <div class="p-6">
                    @if($tenant->room->images->count() > 0)
                    <img src="{{ asset('storage/' . $tenant->room->images->first()->image_path) }}" alt="Kamar {{ $tenant->room->room_number }}" class="w-full h-40 object-cover rounded-lg mb-4">
                    @else
                    <div class="w-full h-40 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @endif

                    <h4 class="text-xl font-bold text-gray-900 mb-2">Kamar {{ $tenant->room->room_number }}</h4>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Tipe</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ ucfirst($tenant->room->room_type) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Harga</dt>
                            <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($tenant->room->price, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Kapasitas</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $tenant->room->capacity }} orang</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Status Kamar</dt>
                            <dd>
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                    @if($tenant->room->status === 'tersedia') bg-green-100 text-green-800
                                    @elseif($tenant->room->status === 'terisi') bg-blue-100 text-blue-800
                                    @else bg-orange-100 text-orange-800
                                    @endif">
                                    {{ ucfirst($tenant->room->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>

                    @if($tenant->room->facilities->count() > 0)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <dt class="text-xs font-medium text-gray-500 mb-2">Fasilitas</dt>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tenant->room->facilities as $facility)
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded">{{ $facility->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('admin.rooms.show', $tenant->room) }}" class="block w-full text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                            Lihat Detail Kamar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs font-medium text-gray-500">Total Pembayaran</dt>
                        <dd class="text-lg font-bold text-gray-900">{{ $tenant->payments->count() }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500">Total Dibayar</dt>
                        <dd class="text-lg font-bold text-green-600">
                            Rp {{ number_format($tenant->payments->where('status', 'verified')->sum('amount'), 0, ',', '.') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500">Pending</dt>
                        <dd class="text-lg font-bold text-yellow-600">
                            Rp {{ number_format($tenant->payments->where('status', 'pending')->sum('amount'), 0, ',', '.') }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
