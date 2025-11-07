@extends('layouts.admin')

@section('title', 'Tambah Kamar')
@section('page-title', 'Tambah Kamar Baru')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Form Tambah Kamar</h3>
        </div>

        <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <!-- Room Number & Type -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Kamar <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="room_number"
                        value="{{ old('room_number') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('room_number') border-red-500 @enderror"
                        placeholder="Contoh: A01"
                        required
                    >
                    @error('room_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Kamar <span class="text-red-500">*</span></label>
                    <select name="room_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('room_type') border-red-500 @enderror" required>
                        <option value="">Pilih Tipe</option>
                        <option value="bulanan" {{ old('room_type') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                        <option value="harian" {{ old('room_type') == 'harian' ? 'selected' : '' }}>Harian</option>
                    </select>
                    @error('room_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Capacity & Price -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kapasitas <span class="text-red-500">*</span></label>
                    <input
                        type="number"
                        name="capacity"
                        value="{{ old('capacity', 1) }}"
                        min="1"
                        max="10"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('capacity') border-red-500 @enderror"
                        required
                    >
                    @error('capacity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga <span class="text-red-500">*</span></label>
                    <input
                        type="number"
                        name="price"
                        value="{{ old('price') }}"
                        min="0"
                        step="1000"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('price') border-red-500 @enderror"
                        placeholder="1500000"
                        required
                    >
                    @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('status') border-red-500 @enderror" required>
                    <option value="">Pilih Status</option>
                    <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="terisi" {{ old('status') == 'terisi' ? 'selected' : '' }}>Terisi</option>
                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
                @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea
                    name="description"
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('description') border-red-500 @enderror"
                    placeholder="Deskripsi kamar..."
                >{{ old('description') }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Facilities -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Fasilitas</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($facilities as $facility)
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input
                            type="checkbox"
                            name="facilities[]"
                            value="{{ $facility->id }}"
                            {{ in_array($facility->id, old('facilities', [])) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-green-600 focus:ring-green-500"
                        >
                        <span class="text-sm text-gray-700">{{ $facility->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Images Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Kamar (Max 5)</label>
                <input
                    type="file"
                    name="images[]"
                    multiple
                    accept="image/jpeg,image/jpg,image/png"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('images') border-red-500 @enderror"
                    onchange="previewImages(event)"
                >
                <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB per foto.</p>
                @error('images')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Image Preview -->
                <div id="imagePreview" class="mt-4 grid grid-cols-2 md:grid-cols-5 gap-4"></div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.rooms.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                    Simpan Kamar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImages(event) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    const files = event.target.files;

    if (files.length > 5) {
        alert('Maksimal 5 foto');
        event.target.value = '';
        return;
    }

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
                <div class="absolute top-2 right-2 bg-green-600 text-white text-xs px-2 py-1 rounded">
                    ${i === 0 ? 'Utama' : ''}
                </div>
            `;
            preview.appendChild(div);
        };

        reader.readAsDataURL(file);
    }
}
</script>
@endsection
