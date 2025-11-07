@extends('layouts.tenant')

@section('title', 'Rating & Review')
@section('page-title', 'Rating & Review Saya')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Rating & Review</h2>
            <p class="text-gray-600 mt-1">Kelola rating dan review Anda</p>
        </div>
        <a href="{{ route('tenant.ratings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
            Beri Rating
        </a>
    </div>

    @if($ratings->count() > 0)
    <div class="space-y-4">
        @foreach($ratings as $rating)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="font-bold text-lg">Kamar {{ $rating->room->room_number }}</h3>
                    <p class="text-sm text-gray-600">{{ $rating->created_at->format('d M Y') }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('tenant.ratings.edit', $rating) }}" class="text-blue-600 hover:text-blue-800">
                        Edit
                    </a>
                    <form action="{{ route('tenant.ratings.destroy', $rating) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rating?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                    </form>
                </div>
            </div>

            <div class="flex items-center mb-3">
                @for($i = 1; $i <= 5; $i++)
                <svg class="w-5 h-5 {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                @endfor
                <span class="ml-2 text-sm text-gray-600">({{ $rating->rating }}/5)</span>
            </div>

            @if($rating->review)
            <p class="text-gray-700">{{ $rating->review }}</p>
            @endif
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $ratings->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg shadow p-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada rating</h3>
        <p class="mt-1 text-sm text-gray-500">Berikan rating untuk kamar Anda.</p>
        <div class="mt-6">
            <a href="{{ route('tenant.ratings.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                Beri Rating Sekarang
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
