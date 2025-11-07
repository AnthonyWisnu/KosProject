@extends('layouts.admin')

@section('title', 'Detail User')
@section('page-title', 'Detail User')

@section('content')
<div class="max-w-4xl">
    <!-- User Info -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Informasi User</h3>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    Edit User
                </a>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <p class="text-gray-900">{{ $user->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <p class="text-gray-900">{{ $user->email }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                <p class="text-gray-900">{{ $user->phone ?: '-' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <span class="px-3 py-1 text-xs rounded-full {{ $user->role === 'pemilik' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Terdaftar</label>
                <p class="text-gray-900">{{ $user->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Update</label>
                <p class="text-gray-900">{{ $user->updated_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>

    @if($user->role === 'penyewa')
    <!-- Active Tenant Info -->
    @if($user->activeTenant)
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Kontrak Aktif</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kamar</label>
                <p class="text-gray-900">{{ $user->activeTenant->room->room_number }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">
                    {{ ucfirst($user->activeTenant->status) }}
                </span>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Check In</label>
                <p class="text-gray-900">{{ $user->activeTenant->check_in_date->format('d M Y') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Check Out</label>
                <p class="text-gray-900">{{ $user->activeTenant->check_out_date ? $user->activeTenant->check_out_date->format('d M Y') : '-' }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Tenant History -->
    @if($user->tenants->count() > 0)
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Kontrak</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kamar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($user->tenants()->latest()->get() as $tenant)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Kamar {{ $tenant->room->room_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $tenant->check_in_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $tenant->check_out_date ? $tenant->check_out_date->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs rounded-full {{ $tenant->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($tenant->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    @endif
</div>
@endsection
