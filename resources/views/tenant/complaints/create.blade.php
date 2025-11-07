@extends('layouts.tenant')

@section('title', 'Buat Keluhan Baru')
@section('page-title', 'Buat Keluhan Baru')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('tenant.complaints.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kamar <span class="text-red-500">*</span></label>
                <input type="text" value="Kamar {{ $tenant->room->room_number }} - {{ $tenant->room->room_type }}" disabled class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Subjek Keluhan <span class="text-red-500">*</span></label>
                <input type="text" name="subject" value="{{ old('subject') }}" required maxlength="255" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Contoh: AC tidak dingin">
                @error('subject')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Keluhan <span class="text-red-500">*</span></label>
                <textarea name="description" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Jelaskan masalah yang Anda alami secara detail...">{{ old('description') }}</textarea>
                @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas <span class="text-red-500">*</span></label>
                <select name="priority" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">Pilih Prioritas</option>
                    <option value="rendah" {{ old('priority') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                    <option value="sedang" {{ old('priority') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="tinggi" {{ old('priority') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                    Tinggi: Masalah urgent yang perlu segera ditangani<br>
                    Sedang: Masalah yang perlu ditangani dalam waktu dekat<br>
                    Rendah: Masalah yang tidak terlalu mendesak
                </p>
                @error('priority')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                    Kirim Keluhan
                </button>
                <a href="{{ route('tenant.complaints.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
