@extends('layouts.public')

@section('title', 'Kontak Kami')

@section('content')
<div class="bg-gradient-to-r from-green-600 to-green-700 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold">Kontak Kami</h1>
        <p class="text-green-100 mt-2">Hubungi kami untuk informasi lebih lanjut</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Contact Form -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>

            <form action="{{ route('public.contact.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('name') border-red-500 @enderror">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('email') border-red-500 @enderror">
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Telepon <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('phone') border-red-500 @enderror">
                        @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subjek <span class="text-red-500">*</span></label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('subject') border-red-500 @enderror">
                        @error('subject')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pesan <span class="text-red-500">*</span></label>
                        <textarea name="message" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>

        <!-- Contact Info -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Informasi Kontak</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">Telepon</p>
                            <p class="text-gray-600">+62 xxx xxxx xxxx</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">Email</p>
                            <p class="text-gray-600">info@kost.com</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">Alamat</p>
                            <p class="text-gray-600">Jakarta, Indonesia</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Jam Operasional</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Senin - Jumat</span>
                        <span class="font-medium">08:00 - 17:00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Sabtu</span>
                        <span class="font-medium">09:00 - 15:00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Minggu</span>
                        <span class="font-medium">Tutup</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
