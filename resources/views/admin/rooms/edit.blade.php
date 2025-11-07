@extends('layouts.admin')

@section('title', 'Edit Kamar')
@section('page-title', 'Edit Kamar ' . $room->room_number)

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Form Edit Kamar</h3>
        </div>

        <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Room Number & Type -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Kamar <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="room_number"
                        value="{{ old('room_number', $room->room_number) }}"
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
                        <option value="bulanan" {{ old('room_type', $room->room_type) == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                        <option value="harian" {{ old('room_type', $room->room_type) == 'harian' ? 'selected' : '' }}>Harian</option>
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
                        value="{{ old('capacity', $room->capacity) }}"
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
                        value="{{ old('price', $room->price) }}"
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
                    <option value="tersedia" {{ old('status', $room->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="terisi" {{ old('status', $room->status) == 'terisi' ? 'selected' : '' }}>Terisi</option>
                    <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
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
                >{{ old('description', $room->description) }}</textarea>
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
                            {{ in_array($facility->id, old('facilities', $room->facilities->pluck('id')->toArray())) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-green-600 focus:ring-green-500"
                        >
                        <span class="text-sm text-gray-700">{{ $facility->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Existing Images -->
            @if($room->images->count() > 0)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    @foreach($room->images as $image)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Kamar" class="w-full h-32 object-cover rounded-lg border">
                        
                        @if($image->is_primary)
                        <span class="absolute top-2 left-2 px-2 py-1 text-xs bg-green-600 text-white rounded">Primary</span>
                        @else
                        <button type="button" onclick="setPrimary({{ $image->id }})" class="absolute top-2 left-2 px-2 py-1 text-xs bg-gray-600 text-white rounded opacity-0 group-hover:opacity-100 transition">
                            Set Primary
                        </button>
                        @endif

                        <label class="absolute bottom-2 right-2 px-2 py-1 text-xs bg-red-600 text-white rounded cursor-pointer opacity-0 group-hover:opacity-100 transition">
                            <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="mr-1">
                            Hapus
                        </label>
                    </div>
                    @endforeach
                </div>
                <input type="hidden" name="set_primary" id="set_primary_input">
            </div>
            @endif

            <!-- Upload New Images -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Foto Baru (Max 5)</label>
                <input
                    type="file"
                    name="images[]"
                    multiple
                    accept="image/jpeg,image/jpg,image/png"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 @error('images') border-red-500 @enderror"
                >
                <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB per foto.</p>
                @error('images')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.rooms.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                    Update Kamar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function setPrimary(imageId) {
    document.getElementById('set_primary_input').value = imageId;
    alert('Foto akan dijadikan primary setelah form di-submit');
}
</script>
@endsection
