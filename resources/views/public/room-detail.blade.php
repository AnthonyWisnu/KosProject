@extends('layouts.public')

@section('title', 'Detail Kamar ' . $room->room_number)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <a href="{{ route('public.rooms.index') }}" class="text-green-600 hover:text-green-700 mb-4 inline-block">
        ← Kembali ke Daftar Kamar
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Images -->
        <div>
            @if($room->images->count() > 0)
            <img src="{{ asset('storage/' . $room->images->first()->image_path) }}" alt="Kamar {{ $room->room_number }}" class="w-full h-96 object-cover rounded-lg shadow-lg">
            @else
            <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            @endif
        </div>

        <!-- Details -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Kamar {{ $room->room_number }}</h1>
                    <p class="text-gray-600">{{ ucfirst($room->room_type) }}</p>
                </div>
                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                    {{ ucfirst($room->status) }}
                </span>
            </div>

            <p class="text-3xl font-bold text-green-600 mb-6">
                Rp {{ number_format($room->price, 0, ',', '.') }}
                <span class="text-lg text-gray-600 font-normal">/bulan</span>
            </p>

            <div class="space-y-4 mb-6">
                <div class="flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Kapasitas: {{ $room->capacity }} orang
                </div>

                @if($room->facilities->count() > 0)
                <div class="border-t pt-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Fasilitas:</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($room->facilities as $facility)
                        <span class="px-3 py-2 bg-green-50 text-green-700 text-sm rounded-lg">✓ {{ $facility->name }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <a href="{{ route('public.booking.create', $room) }}" class="block w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg text-center font-semibold transition">
                Booking Sekarang
            </a>
        </div>
    </div>
</div>
@endsection
