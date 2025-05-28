@extends('layouts.participant')

@section('title', 'Laporan Akhir')
@section('content')
<div class="container mx-auto max-w-3xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div class="max-w-3xl">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Laporan Akhir Magang</h1>
            <p class="text-gray-600">Manajemen laporan akhir magang Anda. Pastikan laporan sudah sesuai dengan ketentuan sebelum mengirim.</p>

            @if($finalReports->isEmpty())
            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-blue-800 text-sm">⚠️ Anda hanya dapat mengirim laporan akhir satu kali. Pastikan data sudah benar sebelum submit.</p>
            </div>
            @endif
        </div>

        @if($finalReports->isEmpty())
        <a href="{{ route('participant.finalreports.create') }}"
           class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg shadow-sm hover:shadow-md transition-all">
            <i data-feather="plus" class="w-5 h-5 mr-2"></i>
            Buat Laporan Baru
        </a>
        @endif
    </div>

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-lg">
        <div class="flex items-center">
            <i data-feather="check-circle" class="w-6 h-6 text-green-600 mr-2"></i>
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <div class="space-y-6">
        @forelse($finalReports as $report)
        <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-shadow border border-gray-200">
            <div class="p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-sm font-medium text-gray-600">
                                {{ \Carbon\Carbon::parse($report->submission_date)->translatedFormat('d F Y') }}
                            </span>
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
                                $statusClass = $statusColors[$report->status] ?? 'bg-gray-100 text-gray-800';
                                $statusLabel = $statusText[$report->status] ?? 'Tidak Diketahui';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>
                        <p class="text-gray-800 line-clamp-2">{{ $report->description }}</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('participant.finalreports.show', $report->id) }}"
                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-md transition mr-2">
                            <i data-feather="eye" class="w-4 h-4 mr-1.5"></i>
                            Detail
                        </a>

                        @if($report->status === 'reviewed')
                        <a href="{{ route('participant.finalreports.edit', $report->id) }}"
                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-yellow-600 bg-yellow-50 hover:bg-yellow-100 rounded-md transition">
                            <i data-feather="edit" class="w-4 h-4 mr-1.5"></i>
                            Revisi
                        </a>
                        @endif
                    </div>
                </div>

                @if($report->file_path)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ Storage::url($report->file_path) }}" target="_blank"
                       class="inline-flex items-center text-blue-600 hover:text-blue-800">
                        <i data-feather="file" class="w-4 h-4 mr-2"></i>
                        Download File Laporan
                    </a>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm border border-dashed border-gray-200">
            <div class="p-12 text-center">
                <div class="mb-4 text-gray-400">
                    <i data-feather="file-text" class="w-12 h-12 mx-auto"></i>
                </div>
                <h3 class="text-gray-500 font-medium">Belum ada laporan tersubmit</h3>
                <p class="text-gray-400 text-sm mt-1">Mulai dengan membuat laporan baru</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
