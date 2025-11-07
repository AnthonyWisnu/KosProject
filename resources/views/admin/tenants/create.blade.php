@extends('layouts.admin')

@section('title', 'Tambah Penghuni')
@section('page-title', 'Tambah Penghuni Baru')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Form Tambah Penghuni</h3>
        </div>

        <form action="{{ route('admin.tenants.store') }}" method="POST" class="p-6 space-y-6" x-data="{ userType: '{{ old('user_type', 'existing') }}' }">
            @csrf

            <!-- User Type Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Pengguna <span class="text-red-500">*</span></label>
                <div class="flex space-x-4">
                    <label class="flex items-center cursor-pointer">
                        <input
                            type="radio"
                            name="user_type"
                            value="existing"
                            x-model="userType"
                            {{ old('user_type', 'existing') === 'existing' ? 'checked' : '' }}
                            class="rounded-full border-gray-300 text-green-600 focus:ring-green-500"
                        >
                        <span class="ml-2 text-sm text-gray-700">Pengguna Existing</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input
                            type="radio"
                            name="user_type"
                            value="new"
                            x-model="userType"
                            {{ old('user_type') === 'new' ? 'checked' : '' }}
                            class="rounded-full border-gray-300 text-green-600 focus:ring-green-500"
                        >
                        <span class="ml-2 text-sm text-gray-700">Pengguna Baru</span>
                    </label>
                </div>
            </div>

            <!-- Existing User Selection -->
            <div x-show="userType === 'existing'" x-cloak>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Pengguna <span class="text-red-500">*</span></label>
                <select name="user_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('user_id') border-red-500 @enderror">
                    <option value="">Pilih Pengguna</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                    @endforeach
                </select>
                @error('user_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- New User Fields -->
            <div x-show="userType === 'new'" x-cloak class="space-y-6 p-4 bg-gray-50 rounded-lg">
                <h4 class="font-medium text-gray-900">Data Pengguna Baru</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('name') border-red-500 @enderror"
                            placeholder="Nama lengkap"
                        >
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('email') border-red-500 @enderror"
                            placeholder="email@example.com"
                        >
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('phone') border-red-500 @enderror"
                            placeholder="08xxxxxxxxxx"
                        >
                        @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                        <input
                            type="password"
                            name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('password') border-red-500 @enderror"
                            placeholder="Minimal 8 karakter"
                        >
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Room Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kamar <span class="text-red-500">*</span></label>
                <select name="room_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('room_id') border-red-500 @enderror" required>
                    <option value="">Pilih Kamar</option>
                    @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
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
                        value="{{ old('start_date', date('Y-m-d')) }}"
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
                        value="{{ old('end_date') }}"
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
                        value="{{ old('ktp') }}"
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
                        value="{{ old('pekerjaan') }}"
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
                    >{{ old('alamat_asal') }}</textarea>
                    @error('alamat_asal')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kontak Darurat <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="kontak_darurat"
                        value="{{ old('kontak_darurat') }}"
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
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                    Simpan Penghuni
                </button>
            </div>
        </form>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection
