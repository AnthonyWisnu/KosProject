@extends('layouts.admin')

@section('title', 'Manajemen Fasilitas')
@section('page-title', 'Manajemen Fasilitas')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Fasilitas</h2>
            <p class="text-gray-600 mt-1">Kelola fasilitas yang tersedia di kost</p>
        </div>
        <a href="{{ route('admin.facilities.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg flex items-center space-x-2 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Fasilitas</span>
        </a>
    </div>

    <!-- Facilities Grid -->
    @if($facilities->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($facilities as $facility)
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $facility->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Digunakan di {{ $facility->rooms_count }} kamar</p>
                    @if($facility->icon)
                    <p class="text-xs text-gray-400 mt-1">Icon: {{ $facility->icon }}</p>
                    @endif
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.facilities.edit', $facility) }}" class="text-green-600 hover:text-green-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    <form action="{{ route('admin.facilities.destroy', $facility) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus fasilitas ini?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="bg-white rounded-lg shadow px-6 py-4">
        {{ $facilities->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg shadow text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada fasilitas</h3>
        <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan fasilitas baru.</p>
        <div class="mt-6">
            <a href="{{ route('admin.facilities.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Fasilitas
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
