@extends('layouts.admin')

@section('title', 'Detail Reservasi')
@section('page-title', 'Detail Reservasi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Detail Reservasi</h2>
            <p class="text-gray-600 mt-1">Informasi lengkap reservasi</p>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Booking Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Booking Details -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Reservasi</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Nama Tamu</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $booking->guest_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Email</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $booking->guest_email }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Telepon</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $booking->guest_phone }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Status</dt>
                            <dd>
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full
                                    @if($booking->status === 'confirmed') bg-blue-100 text-blue-800
                                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($booking->status === 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Check In</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $booking->check_in_date->format('d F Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Check Out</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $booking->check_out_date->format('d F Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Durasi</dt>
                            <dd class="text-sm font-medium text-gray-900">
                                {{ $booking->check_in_date->diffInDays($booking->check_out_date) }} hari
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Total Harga</dt>
                            <dd class="text-lg font-bold text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Status Pembayaran</dt>
                            <dd>
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full
                                    {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $booking->payment_status === 'paid' ? 'Paid' : 'Unpaid' }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Tanggal Booking</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $booking->created_at->format('d M Y H:i') }}</dd>
                        </div>
                    </dl>

                    @if($booking->notes)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <dt class="text-xs font-medium text-gray-500 mb-2">Catatan</dt>
                        <dd class="text-sm text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $booking->notes }}</dd>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payment History -->
            @if($booking->payments->count() > 0)
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Riwayat Pembayaran</h3>
                </div>
                <div class="overflow-x-auto">
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
                            @foreach($booking->payments as $payment)
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
                </div>
            </div>
            @endif

            <!-- Status Actions -->
            @if($booking->status === 'pending')
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Tindakan</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
                                <option value="">Pilih Status</option>
                                <option value="confirmed">Konfirmasi</option>
                                <option value="cancelled">Batalkan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                            <textarea
                                name="notes"
                                rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                placeholder="Tambahkan catatan jika diperlukan..."
                            >{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex space-x-4">
                            <button
                                type="submit"
                                class="flex-1 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition"
                            >
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            @if($booking->status === 'confirmed')
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Selesaikan Reservasi</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.bookings.status', $booking) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="completed">
                        <button
                            type="submit"
                            onclick="return confirm('Yakin ingin menandai reservasi ini sebagai selesai?')"
                            class="w-full px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition"
                        >
                            Tandai Sebagai Selesai
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Room Info -->
        <div class="space-y-6">
            <!-- Room Card -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Kamar</h3>
                </div>
                <div class="p-6">
                    @if($booking->room->images->count() > 0)
                    <img src="{{ asset('storage/' . $booking->room->images->first()->image_path) }}" alt="Kamar {{ $booking->room->room_number }}" class="w-full h-40 object-cover rounded-lg mb-4">
                    @else
                    <div class="w-full h-40 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @endif

                    <h4 class="text-lg font-bold text-gray-900 mb-3">Kamar {{ $booking->room->room_number }}</h4>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Tipe</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ ucfirst($booking->room->room_type) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Harga</dt>
                            <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($booking->room->price, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Kapasitas</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $booking->room->capacity }} orang</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Status Kamar</dt>
                            <dd>
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                    @if($booking->room->status === 'tersedia') bg-green-100 text-green-800
                                    @elseif($booking->room->status === 'terisi') bg-blue-100 text-blue-800
                                    @else bg-orange-100 text-orange-800
                                    @endif">
                                    {{ ucfirst($booking->room->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>

                    @if($booking->room->facilities->count() > 0)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <dt class="text-xs font-medium text-gray-500 mb-2">Fasilitas</dt>
                        <div class="flex flex-wrap gap-2">
                            @foreach($booking->room->facilities as $facility)
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded">{{ $facility->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('admin.rooms.show', $booking->room) }}" class="block w-full text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                            Lihat Detail Kamar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
