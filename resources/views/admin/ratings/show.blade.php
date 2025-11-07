@extends('layouts.admin')

@section('title', 'Detail Rating')
@section('page-title', 'Detail Rating')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Rating untuk Kamar {{ $rating->room->room_number }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $rating->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.ratings.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                    Kembali
                </a>
                <form action="{{ route('admin.ratings.destroy', $rating) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rating ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                        Hapus Rating
                    </button>
                </form>
            </div>
        </div>

        <!-- Rating Display -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
            <div class="flex items-center space-x-2">
                <div class="flex">
                    @for($i = 1; $i <= 5; $i++)
                    <svg class="w-8 h-8 {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    @endfor
                </div>
                <span class="text-2xl font-bold text-gray-900">{{ $rating->rating }}/5</span>
            </div>
        </div>

        <!-- Review -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Review</label>
            <div class="bg-gray-50 rounded-lg p-4">
                @if($rating->review)
                    <p class="text-gray-900">{{ $rating->review }}</p>
                @else
                    <p class="text-gray-500 italic">Tidak ada review tertulis</p>
                @endif
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Penghuni</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <p class="text-gray-900">{{ $rating->user->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <p class="text-gray-900">{{ $rating->user->email }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                <p class="text-gray-900">{{ $rating->user->phone ?? '-' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <p class="text-gray-900">{{ ucfirst($rating->user->role) }}</p>
            </div>
        </div>
    </div>

    <!-- Room Information -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Kamar</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                @if($rating->room->images->count() > 0)
                <img src="{{ asset('storage/' . $rating->room->images->first()->image_path) }}" alt="Kamar {{ $rating->room->room_number }}" class="w-full h-48 object-cover rounded-lg mb-4">
                @else
                <div class="w-full h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                    <span class="text-gray-400">Tidak ada gambar</span>
                </div>
                @endif
            </div>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Kamar</label>
                    <p class="text-gray-900">{{ $rating->room->room_number }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Kamar</label>
                    <p class="text-gray-900">{{ ucfirst($rating->room->room_type) }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                    <p class="text-gray-900 font-semibold">Rp {{ number_format($rating->room->price, 0, ',', '.') }}/bulan</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <span class="px-3 py-1 text-xs rounded-full {{ $rating->room->status === 'tersedia' ? 'bg-green-100 text-green-800' : ($rating->room->status === 'terisi' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst($rating->room->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
