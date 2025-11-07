@extends('layouts.public')

@section('title', 'Daftar Kamar')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-green-600 to-green-700 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold">Daftar Kamar</h1>
        <p class="text-green-100 mt-2">Pilih kamar yang sesuai dengan kebutuhan Anda</p>
    </div>
</div>

<!-- Filters -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <form method="GET" class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Kamar</label>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Tipe</option>
                    <option value="standar" {{ request('type') == 'standar' ? 'selected' : '' }}>Standar</option>
                    <option value="deluxe" {{ request('type') == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                    <option value="vip" {{ request('type') == 'vip' ? 'selected' : '' }}>VIP</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Harga Min</label>
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Rp 0" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Harga Max</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Rp 10,000,000" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    Filter
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Rooms Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    @if($rooms->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($rooms as $room)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
            @if($room->images->count() > 0)
            <img src="{{ asset('storage/' . $room->images->first()->image_path) }}" alt="Kamar {{ $room->room_number }}" class="w-full h-48 object-cover">
            @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            @endif

            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Kamar {{ $room->room_number }}</h3>
                        <p class="text-sm text-gray-600">{{ ucfirst($room->room_type) }}</p>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                        Tersedia
                    </span>
                </div>

                <p class="text-2xl font-bold text-green-600 mb-4">
                    Rp {{ number_format($room->price, 0, ',', '.') }}
                    <span class="text-sm text-gray-600 font-normal">/bulan</span>
                </p>

                <div class="flex items-center text-sm text-gray-600 mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Kapasitas: {{ $room->capacity }} orang
                </div>

                @if($room->facilities->count() > 0)
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($room->facilities->take(3) as $facility)
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">{{ $facility->name }}</span>
                    @endforeach
                    @if($room->facilities->count() > 3)
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">+{{ $room->facilities->count() - 3 }} lainnya</span>
                    @endif
                </div>
                @endif

                <div class="flex space-x-2">
                    <a href="{{ route('public.rooms.show', $room) }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-center transition">
                        Detail
                    </a>
                    <a href="{{ route('public.booking.create', $room) }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-center transition">
                        Booking
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $rooms->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg shadow-lg p-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada kamar yang sesuai</h3>
        <p class="mt-1 text-sm text-gray-500">Coba ubah filter pencarian Anda</p>
    </div>
    @endif
</div>
@endsection
