@extends('layouts.tenant')

@section('title', 'Riwayat Pembayaran')
@section('page-title', 'Riwayat Pembayaran')

@section('content')
<!-- Info Kontrak -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Kontrak Aktif</h3>
            <p class="text-gray-600 mt-1">Kamar {{ $tenant->room->room_number }} - {{ $tenant->room->room_type }}</p>
            <p class="text-gray-600">Harga: Rp {{ number_format($tenant->room->price, 0, ',', '.') }}/bulan</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">Periode Kontrak</p>
            <p class="text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($tenant->check_in_date)->format('d M Y') }}</p>
            <p class="text-gray-500">s/d</p>
            <p class="text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($tenant->check_out_date)->format('d M Y') }}</p>
        </div>
    </div>
</div>

<!-- Payments Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Pembayaran</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Jatuh Tempo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($payments as $payment)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $payment->payment_period }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ \Carbon\Carbon::parse($payment->due_date)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($payment->payment_status === 'lunas')
                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">Lunas</span>
                        @elseif($payment->payment_status === 'menunggu')
                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Menunggu Verifikasi</span>
                        @else
                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-800">Belum Bayar</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('tenant.payments.show', $payment) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        Belum ada data pembayaran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($payments->hasPages())
    <div class="px-6 py-4 border-t">
        {{ $payments->links() }}
    </div>
    @endif
</div>
@endsection
