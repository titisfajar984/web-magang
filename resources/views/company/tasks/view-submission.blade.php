@extends('layouts.company')

@section('title', 'Lihat Jawaban Peserta')

@section('content')
<div class="container mx-auto max-w-5xl px-4 py-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $task->name }}</h1>
            <p class="text-gray-500 mt-1">Jawaban dari peserta: {{ $participant->user->name ?? '-' }}</p>
        </div>
        <a href="{{ route('company.tasks.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali ke Daftar Tugas
        </a>
    </div>

    <!-- Task Details -->
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Tugas</h2>
        <div class="prose max-w-none text-gray-600 mb-6">{!! nl2br(e($task->description)) !!}</div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Deadline</h3>
                <p class="mt-1 text-sm text-gray-900">
                    {{ \Carbon\Carbon::parse($task->deadline)->timezone('Asia/Jakarta')->format('d M Y') }}
                    <span class="ml-2 {{ now()->timezone('Asia/Jakarta')->gt(\Carbon\Carbon::parse($task->deadline)->timezone('Asia/Jakarta')) ? 'text-red-600' : 'text-gray-500' }}">
                        ({{ \Carbon\Carbon::parse($task->deadline)->timezone('Asia/Jakarta')->diffForHumans() }})
                    </span>
                </p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Status Tugas</h3>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                    {{ $task->status === 'Done' ? 'bg-green-100 text-green-800' : ($task->status === 'In Progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                    {{ $task->status === 'Done' ? 'Selesai' : ($task->status === 'In Progress' ? 'Sedang Dikerjakan' : 'Ditugaskan') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Submission Section -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Jawaban Peserta</h2>

        @if($submission)
            <div class="mb-6 p-4 border border-green-100 rounded-lg bg-green-50">
                <div class="flex items-center space-x-3">
                    <i data-feather="check-circle" class="h-6 w-6 text-green-400"></i>
                    <div>
                        <p class="text-sm font-medium text-green-800">
                            Dikirim pada {{ \Carbon\Carbon::parse($submission->updated_at)->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                            @if($submission->updated_at > $task->deadline)
                                <span class="ml-2 text-red-600">(Terlambat)</span>
                            @endif
                        </p>
                        <p class="text-sm text-green-700 mt-1">
                            Status:
                            <span class="font-semibold {{ $submission->status === 'Late' ? 'text-yellow-600' : 'text-green-600' }}">
                                {{ $submission->status ?? 'Terkirim' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            @if($submission->submission_text)
            <div class="mb-6">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Teks Jawaban</h3>
                <div class="prose max-w-none bg-gray-50 p-4 rounded-lg whitespace-pre-line text-gray-800">
                    {{ $submission->submission_text }}
                </div>
            </div>
            @endif

            @if($submission->attachment_file)
            <div class="mb-6">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Lampiran</h3>
                <a href="{{ Storage::url($submission->attachment_file) }}" target="_blank"
                   class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <i data-feather="paperclip" class="w-5 h-5 mr-2"></i>
                    Unduh Lampiran
                </a>
            </div>
            @endif
        @else
            <p class="text-gray-500">Peserta belum mengumpulkan jawaban untuk tugas ini.</p>
        @endif
    </div>
</div>
@endsection
