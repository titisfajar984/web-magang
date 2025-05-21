@extends('layouts.participant')

@section('title', 'Edit Jawaban Tugas')

@section('content')
<div class="container mx-auto max-w-full px-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Jawaban Tugas</h1>
            <p class="text-gray-500 mt-1">Perbarui jawaban dan lampiran tugas Anda</p>
        </div>
        <a href="{{ route('participant.tasks.show', $submission->task_id) }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali
        </a>
    </div>

    <!-- Edit Form -->
    <div class="bg-white shadow rounded-lg p-6 w-full">
        <form method="POST" action="{{ route('participant.tasks.update', $submission->task_id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="submission_text" class="block text-sm font-medium text-gray-700 mb-2">Jawaban *</label>
                <textarea id="submission_text" name="submission_text" rows="6" required
                          class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2">{{ old('submission_text', $submission->submission_text) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Lampiran File</label>
                @if($submission->attachment_file)
                    <div class="mb-2">
                        <p class="text-sm text-gray-600">File saat ini:</p>
                        <div class="flex items-center space-x-2 mt-1">
                        <i data-feather="file-text" class="w-5 h-5 text-gray-500"></i>
                        <a href="{{ Storage::url($submission->attachment_file) }}"
                            target="_blank"
                            class="text-sm text-blue-600 hover:underline truncate max-w-xs">
                            {{ basename($submission->attachment_file) }}
                        </a>
                        </div>
                    </div>
                @endif
                <div class="mt-1 flex items-center">
                    <input type="file" name="attachment_file" id="attachment_file"
                           class="p-2 block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none">
                </div>
                <p class="mt-1 text-sm text-gray-500">Biarkan kosong jika tidak ingin mengganti file. Format: PDF, DOC, DOCX, JPG, PNG (Maks. 5MB)</p>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('participant.tasks.show', $submission->task_id) }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i data-feather="save" class="w-4 h-4 mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
