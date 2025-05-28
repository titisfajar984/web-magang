@extends('layouts.company')

@section('title', 'Detail Laporan Akhir')

@section('content')
<div class="container mx-auto max-w-5xl px-4">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 mb-1">Laporan Akhir Peserta</h1>
            <p class="text-gray-600">Peserta: <strong>{{ $participant->user->name }}</strong></p>
        </div>
        <a href="{{ route('company.participants.index') }}"
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Kembali
        </a>
    </div>

    @if(!$finalReport)
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Laporan Akhir</h2>
            <p class="text-gray-600 mb-4">Peserta belum mengirimkan laporan akhir untuk ditinjau.</p>
            <i data-feather="file-off" class="w-12 h-12 text-gray-400 mx-auto"></i>
        </div>
    @else
        @if($errors->any())
            <div class="mb-4 p-4 rounded bg-red-100 text-red-800">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Konten Laporan</h2>
            <div class="prose max-w-none text-gray-700">
                {!! nl2br(e($finalReport->description)) !!}
            </div>

            @if($finalReport->file_path)
                <div class="mt-4">
                    <p class="text-sm text-gray-700">Lampiran Laporan:</p>
                    <a href="{{ asset('storage/' . $finalReport->file_path) }}" target="_blank"
                       class="text-blue-600 hover:underline inline-flex items-center">
                        <i data-feather="file-text" class="w-4 h-4 mr-1"></i> Unduh File
                    </a>
                </div>
            @endif

            <hr class="my-6">

            <h2 class="text-lg font-semibold text-gray-900 mb-4">Status & Tanggapan</h2>

            <form action="{{ route('company.finalreports.update', $finalReport->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="submitted" @selected($finalReport->status === 'submitted')>Dikirimkan</option>
                        <option value="reviewed" @selected($finalReport->status === 'reviewed')>Revisi</option>
                        <option value="approved" @selected($finalReport->status === 'approved')>Disetujui</option>
                    </select>
                </div>

                <div>
                    <label for="feedback" class="block text-sm font-medium text-gray-700 mb-1">Feedback (Opsional, wajib jika status: reviewed)</label>
                    <textarea name="feedback" id="feedback" rows="4" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('feedback', $finalReport->feedback) }}</textarea>
                </div>

                <div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

            @if($finalReport->feedback)
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-500">Feedback Sebelumnya</h3>
                    <p class="text-gray-800 mt-1">{{ $finalReport->feedback }}</p>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
