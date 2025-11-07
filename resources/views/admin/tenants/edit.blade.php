@extends('layouts.admin')

@section('title', 'Edit Penghuni')
@section('page-title', 'Edit Data Penghuni')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Form Edit Penghuni</h3>
        </div>

        <form action="{{ route('admin.tenants.update', $tenant) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- User Info (Read-only) -->
            <div class="p-4 bg-gray-50 rounded-lg">
                <h4 class="font-medium text-gray-900 mb-3">Informasi Pengguna</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Nama</label>
                        <p class="text-sm text-gray-900">{{ $tenant->user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                        <p class="text-sm text-gray-900">{{ $tenant->user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Telepon</label>
                        <p class="text-sm text-gray-900">{{ $tenant->user->phone }}</p>
                    </div>
                </div>
            </div>

            <!-- Room Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kamar <span class="text-red-500">*</span></label>
                <select name="room_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('room_id') border-red-500 @enderror" required>
                    <option value="">Pilih Kamar</option>
                    @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ (old('room_id', $tenant->room_id) == $room->id) ? 'selected' : '' }}>
                        Kamar {{ $room->room_number }} - Rp {{ number_format($room->price, 0, ',', '.') }} ({{ ucfirst($room->status) }})
                    </option>
                    @endforeach
                </select>
                @error('room_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date Range -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input
                        type="date"
                        name="start_date"
                        value="{{ old('start_date', $tenant->start_date->format('Y-m-d')) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('start_date') border-red-500 @enderror"
                        required
                    >
                    @error('start_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai (Opsional)</label>
                    <input
                        type="date"
                        name="end_date"
                        value="{{ old('end_date', $tenant->end_date?->format('Y-m-d')) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('end_date') border-red-500 @enderror"
                    >
                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ada batas waktu</p>
                    @error('end_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Biodata Section -->
            <div class="p-4 bg-gray-50 rounded-lg space-y-6">
                <h4 class="font-medium text-gray-900">Biodata Penghuni</h4>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor KTP <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="ktp"
                        value="{{ old('ktp', $tenant->biodata['ktp'] ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('ktp') border-red-500 @enderror"
                        placeholder="16 digit nomor KTP"
                        maxlength="16"
                        required
                    >
                    @error('ktp')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="pekerjaan"
                        value="{{ old('pekerjaan', $tenant->biodata['pekerjaan'] ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('pekerjaan') border-red-500 @enderror"
                        placeholder="Contoh: Mahasiswa, Karyawan, Wiraswasta"
                        required
                    >
                    @error('pekerjaan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Asal <span class="text-red-500">*</span></label>
                    <textarea
                        name="alamat_asal"
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('alamat_asal') border-red-500 @enderror"
                        placeholder="Alamat lengkap sesuai KTP"
                        required
                    >{{ old('alamat_asal', $tenant->biodata['alamat_asal'] ?? '') }}</textarea>
                    @error('alamat_asal')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kontak Darurat <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="kontak_darurat"
                        value="{{ old('kontak_darurat', $tenant->biodata['kontak_darurat'] ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('kontak_darurat') border-red-500 @enderror"
                        placeholder="Nama & nomor telepon (contoh: Ibu Siti - 08123456789)"
                        required
                    >
                    @error('kontak_darurat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('status') border-red-500 @enderror" required>
                    <option value="">Pilih Status</option>
                    <option value="active" {{ old('status', $tenant->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $tenant->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.tenants.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                    Update Penghuni
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
