@extends('layouts.tenant')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="max-w-4xl">
    <!-- Active Tenant Info -->
    @if($tenant)
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Kontrak Aktif</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Kamar</p>
                <p class="text-gray-900 font-semibold">{{ $tenant->room->room_number }} - {{ $tenant->room->room_type }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Harga Sewa</p>
                <p class="text-gray-900 font-semibold">Rp {{ number_format($tenant->room->price, 0, ',', '.') }}/bulan</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Check-In</p>
                <p class="text-gray-900">{{ \Carbon\Carbon::parse($tenant->check_in_date)->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Check-Out</p>
                <p class="text-gray-900">{{ \Carbon\Carbon::parse($tenant->check_out_date)->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <span class="px-3 py-1 text-xs rounded-full {{ $tenant->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($tenant->status) }}
                </span>
            </div>
        </div>
    </div>
    @endif

    <!-- Profile Form -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-6">Edit Profil</h3>

        <form action="{{ route('tenant.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Password Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-6">Ubah Password</h3>

        <form action="{{ route('tenant.profile.update-password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 max-w-md">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini <span class="text-red-500">*</span></label>
                    <input type="password" name="current_password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @error('current_password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
