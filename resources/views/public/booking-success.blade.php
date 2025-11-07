@extends('layouts.public')

@section('title', 'Booking Berhasil')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-4">Booking Berhasil!</h1>
        <p class="text-gray-600 mb-8">Terima kasih telah melakukan booking. Kami akan segera menghubungi Anda untuk konfirmasi.</p>

        <div class="bg-gray-50 rounded-lg p-6 text-left mb-8">
            <h3 class="font-bold text-gray-900 mb-4">Detail Booking</h3>
            <dl class="space-y-2">
                <div class="flex justify-between">
                    <dt class="text-gray-600">Kamar:</dt>
                    <dd class="font-medium">{{ $booking->room->room_number }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-600">Nama:</dt>
                    <dd class="font-medium">{{ $booking->guest_name }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-600">Check In:</dt>
                    <dd class="font-medium">{{ $booking->check_in_date->format('d M Y') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-600">Check Out:</dt>
                    <dd class="font-medium">{{ $booking->check_out_date->format('d M Y') }}</dd>
                </div>
                <div class="flex justify-between border-t pt-2">
                    <dt class="text-gray-600">Total:</dt>
                    <dd class="font-bold text-green-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</dd>
                </div>
            </dl>
        </div>

        <a href="{{ route('home') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
