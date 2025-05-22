@extends('layouts.company')

@section('title', 'Detail Jawaban Peserta')

@section('content')
<div class="container mx-auto max-w-full px-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $task->name }}</h1>
            <p class="text-gray-500 mt-1">Jawaban peserta: <span class="font-medium text-gray-800">{{ $participant->user->name ?? '-' }}</span></p>
        </div>
        <a href="{{ route('company.tasks.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali ke Daftar Tugas
        </a>
    </div>

    <!-- Task Detail -->
    <div class="bg-white shadow rounded-lg p-6 mb-6 w-full">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Tugas</h2>
        <div class="prose max-w-none text-gray-600 mb-6">{!! nl2br(e($task->description)) !!}</div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Deadline</h3>
                <p class="mt-1 text-sm text-gray-900">
                    {{ \Carbon\Carbon::parse($task->deadline)->timezone('Asia/Jakarta')->format('d M Y') }}
                    <span class="ml-2 {{ now()->gt($task->deadline) ? 'text-red-600' : 'text-gray-500' }}">
                        ({{ $task->deadline->diffForHumans() }})
                    </span>
                </p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Status</h3>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                    {{ $task->status === 'Done' ? 'bg-green-100 text-green-800' : ($task->status === 'In Progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                    {{ $task->status === 'Done' ? 'Selesai' : ($task->status === 'In Progress' ? 'Sedang Dikerjakan' : 'Ditugaskan') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Jawaban Peserta -->
    <div class="bg-white shadow rounded-lg p-6 w-full">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Jawaban Peserta</h2>

        @if($submission)
            <div class="mb-6 p-4 border border-green-100 rounded-lg bg-green-50">
                <div class="flex items-center space-x-3">
                    <i data-feather="check-circle" class="h-6 w-6 text-green-400"></i>
                    <div>
                        <p class="text-sm font-medium text-green-800">
                            Dikirim pada {{ $submission->updated_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                            @if($submission->updated_at->gt($task->deadline))
                                <span class="ml-2 text-red-600">(Terlambat)</span>
                            @endif
                        </p>
                        <p class="text-sm text-green-700 mt-1">
                            Status:
                            <span class="font-semibold {{ $submission->status === 'Late' ? 'text-yellow-600' : 'text-green-600' }}">
                                {{ $submission->status === 'Late' ? 'Terlambat' : 'Terkirim' }}
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

            {{-- Review dari Perusahaan --}}
            @if($submission->review_status || $submission->review_notes)
            <div class="mt-6 border-t pt-6">
                <h3 class="text-md font-semibold text-gray-800 mb-2">Review Perusahaan</h3>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium
                    {{ $submission->review_status === 'approved' ? 'bg-green-100 text-green-800' :
                       ($submission->review_status === 'rejected' ? 'bg-red-100 text-red-800' :
                       ($submission->review_status === 'revision' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-700')) }}">
                    {{
                        $submission->review_status === 'approved' ? 'Disetujui' :
                        ($submission->review_status === 'rejected' ? 'Ditolak' :
                        ($submission->review_status === 'revision' ? 'Revisi' : 'Menunggu'))
                    }}
                </span>
                @if($submission->review_notes)
                <div class="text-sm text-gray-700 bg-gray-50 p-4 mt-2 rounded-lg whitespace-pre-line">
                    {{ $submission->review_notes }}
                </div>
                @endif
            </div>
            @endif

            {{-- Form Review --}}
            <div class="mt-8 border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Beri Review</h3>
                <form action="{{ route('company.tasks.review-submission', $submission->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="review_status" class="block text-sm font-medium text-gray-700 mb-1">Status Review</label>
                        <select id="review_status" name="review_status" required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-blue-200">
                            <option value="">Pilih Status</option>
                            <option value="approved" {{ old('review_status', $submission->review_status) === 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ old('review_status', $submission->review_status) === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="revision" {{ old('review_status', $submission->review_status) === 'revision' ? 'selected' : '' }}>Revisi</option>
                            <option value="pending" {{ old('review_status', $submission->review_status) === 'pending' ? 'selected' : '' }}>Menunggu</option>
                        </select>
                        @error('review_status')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="review_notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                        <textarea id="review_notes" name="review_notes" rows="4"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-blue-200">{{ old('review_notes', $submission->review_notes) }}</textarea>
                        @error('review_notes')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Review
                    </button>
                </form>
            </div>

        @else
            <p class="text-gray-500 italic">Peserta belum mengirimkan jawaban untuk tugas ini.</p>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    if (window.feather) {
        feather.replace();
    }
</script>
@endsection
