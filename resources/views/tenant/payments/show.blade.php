@extends('layouts.tenant')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')

@section('content')
<div class="max-w-3xl">
    <!-- Payment Info -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Informasi Pembayaran</h3>
            @if($payment->payment_status === 'lunas')
            <span class="px-4 py-2 text-sm rounded-full bg-green-100 text-green-800 font-semibold">Lunas</span>
            @elseif($payment->payment_status === 'menunggu')
            <span class="px-4 py-2 text-sm rounded-full bg-yellow-100 text-yellow-800 font-semibold">Menunggu Verifikasi</span>
            @else
            <span class="px-4 py-2 text-sm rounded-full bg-red-100 text-red-800 font-semibold">Belum Bayar</span>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Periode Pembayaran</p>
                <p class="text-gray-900 font-semibold">{{ $payment->payment_period }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tanggal Jatuh Tempo</p>
                <p class="text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($payment->due_date)->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Jumlah Pembayaran</p>
                <p class="text-gray-900 font-semibold text-lg">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Kamar</p>
                <p class="text-gray-900 font-semibold">{{ $payment->tenant->room->room_number }} - {{ $payment->tenant->room->room_type }}</p>
            </div>
            @if($payment->payment_date)
            <div>
                <p class="text-sm text-gray-500">Tanggal Pembayaran</p>
                <p class="text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y H:i') }}</p>
            </div>
            @endif
            @if($payment->notes)
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Catatan Admin</p>
                <p class="text-gray-900">{{ $payment->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Payment Proof -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Bukti Pembayaran</h3>

        @if($payment->payment_proof)
        <div class="mb-4">
            <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Bukti Pembayaran" class="max-w-md w-full border rounded-lg">
        </div>
        @endif

        @if($payment->payment_status !== 'lunas')
        <form action="{{ route('tenant.payments.upload-proof', $payment) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $payment->payment_proof ? 'Upload Bukti Baru' : 'Upload Bukti Pembayaran' }}
                    <span class="text-red-500">*</span>
                </label>
                <input type="file" name="payment_proof" accept="image/*" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <p class="mt-1 text-sm text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                @error('payment_proof')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-blue-800">
                    <strong>Informasi Rekening:</strong><br>
                    Bank BCA - 1234567890<br>
                    a.n. Kost Management
                </p>
            </div>

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                Upload Bukti
            </button>
        </form>
        @else
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <p class="text-sm text-green-800">
                Pembayaran sudah diverifikasi dan lunas. Terima kasih!
            </p>
        </div>
        @endif
    </div>

    <div class="mt-6">
        <a href="{{ route('tenant.payments.index') }}" class="text-blue-600 hover:text-blue-800">
            ← Kembali ke Daftar Pembayaran
        </a>
    </div>
</div>
@endsection
