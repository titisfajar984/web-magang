@extends('layouts.participant')

@section('title', 'Detail Tugas')

@section('content')
<div class="container mx-auto max-w-full px-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $task->name }}</h1>
            <p class="text-gray-500 mt-1">Detail tugas dari program magang {{ $task->application->internship->title }}</p>
        </div>
        <a href="{{ route('participant.tasks.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali
        </a>
    </div>

    <!-- Task Details -->
    <div class="bg-white shadow rounded-lg p-6 mb-6 w-full">
        <div class="mb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-2">Deskripsi Tugas</h2>
            <div class="prose max-w-none text-gray-600">
                {!! $task->description !!}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
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
                <h3 class="text-sm font-medium text-gray-500">File Tugas</h3>
                @if($task->file_path)
                <div class="mt-1">
                    <a href="{{ Storage::url($task->file_path) }}" target="_blank"
                       class="inline-flex items-center text-blue-600 hover:text-blue-800">
                        <i data-feather="file" class="w-4 h-4 mr-2"></i>
                        Download File Tugas
                    </a>
                </div>
                @else
                <p class="mt-1 text-sm text-gray-500">Tidak ada file terlampir</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Submission Section -->
    <div class="bg-white shadow rounded-lg p-6 w-full">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Pengumpulan Tugas</h2>

        @if($submission)
            <!-- Tampilkan status pengumpulan -->
            <div class="mb-6 p-4 border border-green-100 rounded-lg bg-green-50">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i data-feather="check-circle" class="h-5 w-5 text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">
                            Anda telah mengumpulkan tugas ini pada {{ \Carbon\Carbon::parse($submission->submission_date)->timezone('Asia/Jakarta')->format('d M Y') }}
                        </h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p>Status:
                                <span class="font-semibold {{ $submission->status == 'Late' ? 'text-yellow-600' : 'text-green-600' }}">
                                    {{ $submission->status == 'Late' ? 'Terlambat' : 'Tepat Waktu' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Review -->
            <div class="mb-6 p-4 border rounded-lg w-full
                @if($submission->review_status === 'approved') border-green-200 bg-green-50
                @elseif($submission->review_status === 'rejected') border-red-200 bg-red-50
                @elseif($submission->review_status === 'revision') border-yellow-200 bg-yellow-50
                @elseif($submission->review_status === 'pending') border-gray-200 bg-gray-50
                @else border-gray-200 bg-gray-50 @endif">
                <div class="flex items-start w-full">
                    <div class="flex-shrink-0">
                        @if($submission->review_status === 'approved')
                        <i data-feather="check-circle" class="h-5 w-5 text-green-500"></i>
                        @elseif($submission->review_status === 'rejected')
                        <i data-feather="x-circle" class="h-5 w-5 text-red-500"></i>
                        @elseif($submission->review_status === 'revision')
                        <i data-feather="alert-circle" class="h-5 w-5 text-yellow-500"></i>
                        @else
                        <i data-feather="clock" class="h-5 w-5 text-gray-500"></i>
                        @endif
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-medium text-gray-800">
                            @if($submission->review_status === 'approved')
                                Jawaban telah disetujui
                            @elseif($submission->review_status === 'rejected')
                                Jawaban ditolak
                            @elseif($submission->review_status === 'revision')
                                Jawaban perlu revisi
                            @elseif($submission->review_status === 'pending')
                                Menunggu review perusahaan
                            @else
                                Belum ada status review
                            @endif
                        </h3>
                        <div class="mt-2 text-sm text-gray-700">
                            <p>Dikirim pada {{ \Carbon\Carbon::parse($submission->updated_at)->timezone('Asia/Jakarta')->format('d M Y') }}
                                @if(\Carbon\Carbon::parse($submission->updated_at)->gt($task->deadline))
                                <span class="ml-2 font-medium">(Terlambat)</span>
                                @endif
                            </p>
                            @if(in_array($submission->review_status, ['rejected', 'revision']) && $submission->review_notes)
                            <div class="mt-2 p-2 bg-white rounded border w-full">
                                <p class="font-medium">Feedback Perusahaan:</p>
                                <p class="whitespace-pre-line">{{ $submission->review_notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jawaban -->
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Jawaban Anda</h3>
                <div class="prose max-w-none bg-gray-50 p-4 rounded-lg">
                    {!! nl2br(e($submission->submission_text)) !!}
                </div>
            </div>

            <!-- Lampiran -->
            @if($submission->attachment_file)
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-700 mb-2">File Lampiran</h3>
                <a href="{{ Storage::url($submission->attachment_file) }}" target="_blank"
                   class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <i data-feather="paperclip" class="w-4 h-4 mr-2"></i>
                    Download Lampiran
                </a>
            </div>
            @endif

            <!-- Tombol Edit -->
            <div class="flex justify-end">
                <a href="{{ route('participant.tasks.edit', $task->id) }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i data-feather="edit" class="w-4 h-4 mr-2"></i>
                    Edit Jawaban
                </a>
            </div>

        @else
            <!-- Form Pengumpulan -->
            <form method="POST" action="{{ route('participant.tasks.submit', $task->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="submission_text" class="block text-sm font-medium text-gray-700 mb-2">Jawaban *</label>
                    <textarea id="submission_text" name="submission_text" rows="6" required
                              class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2"></textarea>
                    <p class="mt-1 text-sm text-gray-500">Tulis jawaban atau penjelasan untuk tugas ini</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lampiran File (Opsional)</label>
                    <input type="file" name="attachment_file" id="attachment_file"
                           class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none p-2">
                    <p class="mt-1 text-sm text-gray-500">Format file: PDF, DOC, DOCX, JPG, PNG (Maks. 5MB)</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i data-feather="upload" class="w-4 h-4 mr-2"></i>
                        Kumpulkan Tugas
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
