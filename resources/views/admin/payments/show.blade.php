@extends('layouts.admin')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Detail Pembayaran</h2>
            <p class="text-gray-600 mt-1">Informasi lengkap pembayaran</p>
        </div>
        <a href="{{ route('admin.payments.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Payment Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Payment Details -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Pembayaran</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Tanggal Pembayaran</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $payment->payment_date->format('d F Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Jumlah</dt>
                            <dd class="text-lg font-bold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Status</dt>
                            <dd>
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full
                                    @if($payment->status === 'verified') bg-green-100 text-green-800
                                    @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </dd>
                        </div>
                        @if($payment->verifiedBy)
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Diverifikasi Oleh</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $payment->verifiedBy->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Tanggal Verifikasi</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $payment->verified_at->format('d M Y H:i') }}</dd>
                        </div>
                        @endif
                        @if($payment->booking)
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Terkait Booking</dt>
                            <dd class="text-sm font-medium text-gray-900">Booking #{{ $payment->booking->id }}</dd>
                        </div>
                        @endif
                    </dl>

                    @if($payment->notes)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <dt class="text-xs font-medium text-gray-500 mb-2">Catatan</dt>
                        <dd class="text-sm text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $payment->notes }}</dd>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payment Proof -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Bukti Pembayaran</h3>
                </div>
                <div class="p-6">
                    @if($payment->payment_proof)
                    <div class="max-w-2xl">
                        <img
                            src="{{ asset('storage/' . $payment->payment_proof) }}"
                            alt="Bukti Pembayaran"
                            class="w-full rounded-lg shadow-md cursor-pointer hover:shadow-lg transition"
                            onclick="openImageModal(this.src)"
                        >
                        <a
                            href="{{ asset('storage/' . $payment->payment_proof) }}"
                            target="_blank"
                            class="inline-flex items-center mt-4 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Lihat Full Size
                        </a>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Tidak ada bukti pembayaran</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Verification Actions -->
            @if($payment->status === 'pending')
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Tindakan Verifikasi</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.payments.verify', $payment) }}" method="POST" class="space-y-4">
                        @csrf
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
                                name="action"
                                value="verify"
                                class="flex-1 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition flex items-center justify-center space-x-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Verifikasi Pembayaran</span>
                            </button>
                            <button
                                type="submit"
                                name="action"
                                value="reject"
                                onclick="return confirm('Yakin ingin menolak pembayaran ini?')"
                                class="flex-1 px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center justify-center space-x-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Tolak Pembayaran</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Tenant Info -->
        <div class="space-y-6">
            <!-- Tenant Card -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Penghuni</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-2xl font-semibold">
                            {{ substr($payment->tenant->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900">{{ $payment->tenant->user->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $payment->tenant->user->email }}</p>
                        </div>
                    </div>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Telepon</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $payment->tenant->user->phone }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Status</dt>
                            <dd>
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $payment->tenant->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($payment->tenant->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-4">
                        <a href="{{ route('admin.tenants.show', $payment->tenant) }}" class="block w-full text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                            Lihat Detail Penghuni
                        </a>
                    </div>
                </div>
            </div>

            <!-- Room Card -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Kamar</h3>
                </div>
                <div class="p-6">
                    @if($payment->tenant->room->images->count() > 0)
                    <img src="{{ asset('storage/' . $payment->tenant->room->images->first()->image_path) }}" alt="Kamar {{ $payment->tenant->room->room_number }}" class="w-full h-32 object-cover rounded-lg mb-4">
                    @else
                    <div class="w-full h-32 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @endif

                    <h4 class="text-lg font-bold text-gray-900 mb-3">Kamar {{ $payment->tenant->room->room_number }}</h4>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Tipe</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ ucfirst($payment->tenant->room->room_type) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Harga</dt>
                            <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($payment->tenant->room->price, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Status</dt>
                            <dd>
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                    @if($payment->tenant->room->status === 'tersedia') bg-green-100 text-green-800
                                    @elseif($payment->tenant->room->status === 'terisi') bg-blue-100 text-blue-800
                                    @else bg-orange-100 text-orange-800
                                    @endif">
                                    {{ ucfirst($payment->tenant->room->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-4">
                        <a href="{{ route('admin.rooms.show', $payment->tenant->room) }}" class="block w-full text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                            Lihat Detail Kamar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="max-w-4xl max-h-screen">
        <img id="modalImage" src="" alt="Bukti Pembayaran" class="max-w-full max-h-screen rounded-lg">
    </div>
</div>

<script>
function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}
</script>
@endsection
