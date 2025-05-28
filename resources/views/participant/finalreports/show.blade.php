@extends('layouts.participant')

@section('title', 'Detail Laporan')

@section('content')
<div class="container mx-auto max-w-3xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Laporan Akhir</h1>
            <p class="text-gray-500 mt-1">
                Dikirimkan pada {{ \Carbon\Carbon::parse($finalReport->submission_date)->translatedFormat('d F Y ') }}
            </p>
        </div>
        <a href="{{ route('participant.finalreports.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6 space-y-6">
        @php
            $statusColors = [
                'submitted' => 'bg-blue-100 text-blue-800',
                'reviewed' => 'bg-yellow-100 text-yellow-800',
                'approved' => 'bg-green-100 text-green-800',
            ];
            $statusText = [
                'submitted' => 'Dikirimkan',
                'reviewed' => 'Revisi',
                'approved' => 'Disetujui',
            ];
            $statusClass = $statusColors[$finalReport->status] ?? 'bg-gray-100 text-gray-800';
            $statusLabel = $statusText[$finalReport->status] ?? 'Tidak Diketahui';
        @endphp

        <!-- Status Badge -->
        <div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                {{ $statusLabel }}
            </span>
        </div>

        <!-- Deskripsi -->
        <div>
            <h3 class="text-sm font-medium text-gray-700 mb-2">Deskripsi Laporan</h3>
            <p class="text-gray-900 whitespace-pre-wrap">{{ $finalReport->description }}</p>
        </div>

        <!-- File Section -->
        <div>
            <h3 class="text-sm font-medium text-gray-700 mb-2">Dokumen Laporan</h3>
            @if($finalReport->file_path)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <i data-feather="file" class="w-6 h-6 text-gray-500"></i>
                        <span class="text-gray-700">{{ basename($finalReport->file_path) }}</span>
                    </div>
                    <a href="{{ Storage::url($finalReport->file_path) }}" target="_blank"
                       class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center">
                        <i data-feather="download" class="w-4 h-4 mr-2"></i>
                        Download
                    </a>
                </div>
            @else
                <p class="text-gray-500">Tidak ada file terlampir</p>
            @endif
        </div>

        <!-- Feedback (jika ada) -->
        @if($finalReport->status === 'reviewed' && $finalReport->feedback)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-yellow-700 mb-2">Feedback dari Perusahaan</h3>
                <p class="text-yellow-800 whitespace-pre-wrap">{{ $finalReport->feedback }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
