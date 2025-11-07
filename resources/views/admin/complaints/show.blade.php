@extends('layouts.admin')

@section('title', 'Detail Keluhan')
@section('page-title', 'Detail Keluhan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Detail Keluhan</h2>
            <p class="text-gray-600 mt-1">Informasi lengkap keluhan</p>
        </div>
        <a href="{{ route('admin.complaints.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Complaint Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Complaint Details -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Keluhan</h3>
                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full
                        @if($complaint->status === 'open') bg-red-100 text-red-800
                        @elseif($complaint->status === 'in_progress') bg-yellow-100 text-yellow-800
                        @elseif($complaint->status === 'resolved') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                    </span>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Judul</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $complaint->title }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 mb-1">Deskripsi</dt>
                            <dd class="text-sm text-gray-900 bg-gray-50 p-4 rounded-lg whitespace-pre-wrap">{{ $complaint->description }}</dd>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="text-xs font-medium text-gray-500 mb-1">Tanggal Dibuat</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $complaint->created_at->format('d F Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 mb-1">Terakhir Diupdate</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $complaint->updated_at->format('d F Y H:i') }}</dd>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Response Section -->
            @if($complaint->response)
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Respons</h3>
                </div>
                <div class="p-6">
                    <div class="bg-green-50 p-4 rounded-lg mb-4">
                        <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $complaint->response }}</p>
                    </div>

                    @if($complaint->respondedBy)
                    <div class="flex items-center text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Ditanggapi oleh <strong>{{ $complaint->respondedBy->name }}</strong> pada {{ $complaint->responded_at->format('d M Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Response Form -->
            @if($complaint->status !== 'closed')
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $complaint->response ? 'Update Respons' : 'Tanggapi Keluhan' }}</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.complaints.respond', $complaint) }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
                                <option value="">Pilih Status</option>
                                <option value="open" {{ old('status', $complaint->status) === 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ old('status', $complaint->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ old('status', $complaint->status) === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="closed" {{ old('status', $complaint->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Respons <span class="text-red-500">*</span></label>
                            <textarea
                                name="response"
                                rows="5"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                placeholder="Tuliskan respons Anda untuk keluhan ini..."
                                required
                            >{{ old('response', $complaint->response) }}</textarea>
                        </div>

                        <div class="flex space-x-4">
                            <button
                                type="submit"
                                class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition"
                            >
                                {{ $complaint->response ? 'Update Respons' : 'Kirim Respons' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - User & Room Info -->
        <div class="space-y-6">
            <!-- User Card -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Penghuni</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-2xl font-semibold">
                            {{ substr($complaint->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900">{{ $complaint->user->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $complaint->user->email }}</p>
                        </div>
                    </div>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Telepon</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $complaint->user->phone }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Role</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ ucfirst($complaint->user->role) }}</dd>
                        </div>
                    </dl>

                    @if($complaint->user->activeTenant)
                    <div class="mt-4">
                        <a href="{{ route('admin.tenants.show', $complaint->user->activeTenant) }}" class="block w-full text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                            Lihat Data Penghuni
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Room Card -->
            @if($complaint->room)
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Kamar</h3>
                </div>
                <div class="p-6">
                    @if($complaint->room->images->count() > 0)
                    <img src="{{ asset('storage/' . $complaint->room->images->first()->image_path) }}" alt="Kamar {{ $complaint->room->room_number }}" class="w-full h-32 object-cover rounded-lg mb-4">
                    @else
                    <div class="w-full h-32 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @endif

                    <h4 class="text-lg font-bold text-gray-900 mb-3">Kamar {{ $complaint->room->room_number }}</h4>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Tipe</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ ucfirst($complaint->room->room_type) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Harga</dt>
                            <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($complaint->room->price, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Status</dt>
                            <dd>
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                    @if($complaint->room->status === 'tersedia') bg-green-100 text-green-800
                                    @elseif($complaint->room->status === 'terisi') bg-blue-100 text-blue-800
                                    @else bg-orange-100 text-orange-800
                                    @endif">
                                    {{ ucfirst($complaint->room->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-4">
                        <a href="{{ route('admin.rooms.show', $complaint->room) }}" class="block w-full text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                            Lihat Detail Kamar
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
