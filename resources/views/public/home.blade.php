@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-green-600 to-green-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Temukan Kost Impian Anda</h1>
            <p class="text-xl md:text-2xl text-green-100 mb-8">Kost nyaman, aman, dan terjangkau</p>
            <a href="{{ route('public.rooms.index') }}" class="inline-block bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Lihat Kamar Tersedia
            </a>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-600">Total Kamar</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalRooms }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-600">Kamar Tersedia</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $availableRooms }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Rooms -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Kamar Tersedia</h2>
        <p class="text-gray-600">Pilih kamar yang sesuai dengan kebutuhan Anda</p>
    </div>

    @if($featuredRooms->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($featuredRooms as $room)
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

    <div class="text-center mt-12">
        <a href="{{ route('public.rooms.index') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition">
            Lihat Semua Kamar
        </a>
    </div>
    @else
    <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada kamar tersedia</h3>
        <p class="mt-1 text-sm text-gray-500">Silakan hubungi kami untuk informasi lebih lanjut.</p>
    </div>
    @endif
</div>

<!-- Why Choose Us -->
<div class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Mengapa Memilih Kami?</h2>
            <p class="text-gray-600">Kami memberikan layanan terbaik untuk kenyamanan Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg p-6 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Aman & Nyaman</h3>
                <p class="text-gray-600">Keamanan 24 jam dengan sistem CCTV dan penjaga keamanan</p>
            </div>

            <div class="bg-white rounded-lg p-6 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Harga Terjangkau</h3>
                <p class="text-gray-600">Harga kompetitif dengan fasilitas lengkap dan berkualitas</p>
            </div>

            <div class="bg-white rounded-lg p-6 text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Lokasi Strategis</h3>
                <p class="text-gray-600">Dekat dengan transportasi umum, kampus, dan pusat perbelanjaan</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-green-600 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Siap Menemukan Kost Anda?</h2>
        <p class="text-xl text-green-100 mb-8">Hubungi kami sekarang untuk informasi lebih lanjut</p>
        <a href="{{ route('public.contact') }}" class="inline-block bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
            Hubungi Kami
        </a>
    </div>
</div>
@endsection
