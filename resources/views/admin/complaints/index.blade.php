@extends('layouts.admin')

@section('title', 'Manajemen Keluhan')
@section('page-title', 'Manajemen Keluhan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Keluhan</h2>
            <p class="text-gray-600 mt-1">Kelola keluhan dari penghuni</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-red-50 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-600 text-sm font-medium">Open</p>
                    <p class="text-2xl font-bold text-red-900 mt-1">{{ $openCount }}</p>
                </div>
                <div class="w-12 h-12 bg-red-200 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-600 text-sm font-medium">In Progress</p>
                    <p class="text-2xl font-bold text-yellow-900 mt-1">{{ $inProgressCount }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-200 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-green-50 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-600 text-sm font-medium">Resolved</p>
                    <p class="text-2xl font-bold text-green-900 mt-1">{{ $resolvedCount }}</p>
                </div>
                <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Closed</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $closedCount }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="GET" action="{{ route('admin.complaints.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Judul atau nama penghuni..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    <option value="">Semua Status</option>
                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kamar</label>
                <select name="room_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    <option value="">Semua Kamar</option>
                    @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                        Kamar {{ $room->room_number }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg flex-1 transition">
                    Filter
                </button>
                <a href="{{ route('admin.complaints.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Complaints Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($complaints->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penghuni</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kamar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($complaints as $complaint)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold">
                                    {{ substr($complaint->user->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">{{ $complaint->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $complaint->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($complaint->room)
                            <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-purple-100 text-purple-800">
                                Kamar {{ $complaint->room->room_number }}
                            </span>
                            @else
                            <span class="text-sm text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $complaint->title }}</div>
                            <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($complaint->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $complaint->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full
                                @if($complaint->status === 'open') bg-red-100 text-red-800
                                @elseif($complaint->status === 'in_progress') bg-yellow-100 text-yellow-800
                                @elseif($complaint->status === 'resolved') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                            </span>
                            @if($complaint->respondedBy)
                            <div class="text-xs text-gray-500 mt-1">
                                oleh {{ $complaint->respondedBy->name }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.complaints.show', $complaint) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                @if($complaint->status !== 'closed')
                                <button
                                    onclick="openRespondModal({{ $complaint->id }})"
                                    class="text-green-600 hover:text-green-900"
                                    title="Tanggapi"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                    </svg>
                                </button>
                                @endif

                                @if($complaint->status === 'closed')
                                <form action="{{ route('admin.complaints.destroy', $complaint) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus keluhan ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t">
            {{ $complaints->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada keluhan</h3>
            <p class="mt-1 text-sm text-gray-500">Data keluhan akan muncul di sini.</p>
        </div>
        @endif
    </div>
</div>

<!-- Respond Modal -->
<div id="respondModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-[500px] shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tanggapi Keluhan</h3>
            <form id="respondForm" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
                        <option value="">Pilih Status</option>
                        <option value="in_progress">In Progress</option>
                        <option value="resolved">Resolved</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Respons <span class="text-red-500">*</span></label>
                    <textarea
                        name="response"
                        rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                        placeholder="Tuliskan respons Anda..."
                        required
                    ></textarea>
                </div>

                <div class="flex space-x-2">
                    <button
                        type="submit"
                        class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition"
                    >
                        Kirim Respons
                    </button>
                    <button
                        type="button"
                        onclick="closeRespondModal()"
                        class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition"
                    >
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRespondModal(complaintId) {
    const modal = document.getElementById('respondModal');
    const form = document.getElementById('respondForm');

    form.action = `/admin/complaints/${complaintId}/respond`;
    modal.classList.remove('hidden');
}

function closeRespondModal() {
    const modal = document.getElementById('respondModal');
    modal.classList.add('hidden');
    document.getElementById('respondForm').reset();
}

// Close modal when clicking outside
document.getElementById('respondModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRespondModal();
    }
});
</script>
@endsection
