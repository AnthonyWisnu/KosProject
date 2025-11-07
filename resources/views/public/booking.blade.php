@extends('layouts.public')

@section('title', 'Booking Kamar ' . $room->room_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Booking Kamar {{ $room->room_number }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Form -->
        <div class="md:col-span-2">
            <form action="{{ route('public.booking.store') }}" method="POST" class="bg-white rounded-lg shadow-lg p-6">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="guest_name" value="{{ old('guest_name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('guest_name') border-red-500 @enderror">
                        @error('guest_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="guest_email" value="{{ old('guest_email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('guest_email') border-red-500 @enderror">
                        @error('guest_email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon <span class="text-red-500">*</span></label>
                        <input type="text" name="guest_phone" value="{{ old('guest_phone') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('guest_phone') border-red-500 @enderror">
                        @error('guest_phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Masuk <span class="text-red-500">*</span></label>
                            <input type="date" name="check_in_date" value="{{ old('check_in_date') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('check_in_date') border-red-500 @enderror">
                            @error('check_in_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Durasi Kontrak <span class="text-red-500">*</span></label>
                            <select name="duration_months" required class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('duration_months') border-red-500 @enderror">
                                <option value="">Pilih Durasi</option>
                                <option value="1" {{ old('duration_months') == '1' ? 'selected' : '' }}>1 Bulan</option>
                                <option value="3" {{ old('duration_months') == '3' ? 'selected' : '' }}>3 Bulan</option>
                                <option value="6" {{ old('duration_months') == '6' ? 'selected' : '' }}>6 Bulan</option>
                                <option value="12" {{ old('duration_months') == '12' ? 'selected' : '' }}>12 Bulan (1 Tahun)</option>
                            </select>
                            @error('duration_months')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        Kirim Booking
                    </button>
                </div>
            </form>
        </div>

        <!-- Room Summary -->
        <div class="bg-white rounded-lg shadow-lg p-6 h-fit">
            <h3 class="font-bold text-gray-900 mb-4">Detail Kamar</h3>
            @if($room->images->count() > 0)
            <img src="{{ asset('storage/' . $room->images->first()->image_path) }}" alt="Kamar {{ $room->room_number }}" class="w-full h-32 object-cover rounded-lg mb-4">
            @endif
            <p class="font-bold text-lg">Kamar {{ $room->room_number }}</p>
            <p class="text-sm text-gray-600 mb-4">{{ ucfirst($room->room_type) }}</p>
            <p class="text-2xl font-bold text-green-600">
                Rp {{ number_format($room->price, 0, ',', '.') }}
                <span class="text-sm text-gray-600 font-normal">/bulan</span>
            </p>
        </div>
    </div>
</div>
@endsection
