@extends('layouts.tenant')

@section('title', 'Detail Keluhan')
@section('page-title', 'Detail Keluhan')

@section('content')
<div class="max-w-3xl">
    <!-- Complaint Info -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">{{ $complaint->subject }}</h3>
            <div class="flex space-x-2">
                @if($complaint->priority === 'tinggi')
                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-800">Tinggi</span>
                @elseif($complaint->priority === 'sedang')
                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Sedang</span>
                @else
                <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Rendah</span>
                @endif

                @if($complaint->status === 'selesai')
                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">Selesai</span>
                @elseif($complaint->status === 'proses')
                <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Diproses</span>
                @else
                <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Pending</span>
                @endif
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <p class="text-sm text-gray-500">Kamar</p>
                <p class="text-gray-900 font-semibold">{{ $complaint->tenant->room->room_number }} - {{ $complaint->tenant->room->room_type }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Deskripsi Keluhan</p>
                <p class="text-gray-900 whitespace-pre-line">{{ $complaint->description }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Dibuat Pada</p>
                <p class="text-gray-900">{{ $complaint->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Admin Response -->
    @if($complaint->admin_response)
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tanggapan Admin</h3>
        
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <p class="text-gray-900 whitespace-pre-line">{{ $complaint->admin_response }}</p>
            
            @if($complaint->resolved_at)
            <p class="text-sm text-gray-500 mt-4">
                Ditanggapi pada: {{ \Carbon\Carbon::parse($complaint->resolved_at)->format('d M Y H:i') }}
            </p>
            @endif
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <p class="text-sm text-yellow-800">
                Keluhan Anda sedang ditinjau oleh admin. Mohon ditunggu.
            </p>
        </div>
    </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('tenant.complaints.index') }}" class="text-blue-600 hover:text-blue-800">
            ← Kembali ke Daftar Keluhan
        </a>
    </div>
</div>
@endsection
