@extends('layouts.tenant')

@section('title', 'Keluhan Saya')
@section('page-title', 'Keluhan Saya')

@section('content')
<!-- Create Button -->
<div class="mb-6">
    <a href="{{ route('tenant.complaints.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition inline-block">
        + Buat Keluhan Baru
    </a>
</div>

<!-- Complaints Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subjek</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioritas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($complaints as $complaint)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $complaint->subject }}</div>
                        <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($complaint->description, 60) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($complaint->priority === 'tinggi')
                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-800">Tinggi</span>
                        @elseif($complaint->priority === 'sedang')
                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Sedang</span>
                        @else
                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Rendah</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($complaint->status === 'selesai')
                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">Selesai</span>
                        @elseif($complaint->status === 'proses')
                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Diproses</span>
                        @else
                        <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Pending</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $complaint->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('tenant.complaints.show', $complaint) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        Belum ada keluhan. Silakan buat keluhan baru jika ada masalah.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($complaints->hasPages())
    <div class="px-6 py-4 border-t">
        {{ $complaints->links() }}
    </div>
    @endif
</div>
@endsection
