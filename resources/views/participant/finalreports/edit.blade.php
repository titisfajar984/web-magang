@extends('layouts.participant')

@section('title', 'Revisi Laporan')
@section('content')
<div class="container mx-auto max-w-3xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Revisi Laporan</h1>
            <p class="text-gray-500 mt-1">Update sesuai feedback perusahaan</p>
        </div>
        <a href="{{ route('participant.finalreports.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('participant.finalreports.update', $finalReport) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Current File -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        File Saat Ini
                    </label>
                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg">
                        <i data-feather="file" class="w-6 h-6 text-gray-500"></i>
                        <span class="text-gray-700 flex-1">
                            {{ basename($finalReport->file_path) }}
                        </span>
                        <a href="{{ Storage::url($finalReport->file_path) }}" target="_blank"
                           class="text-blue-600 hover:text-blue-800">
                            <i data-feather="download" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Revisi
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" rows="4" required
                              class="block w-full border border-gray-300 rounded-lg px-4 py-3
                                     focus:border-blue-500 focus:ring-blue-500
                                     @error('description') border-red-500 @enderror"
                              placeholder="Jelaskan perubahan yang Anda lakukan...">{{ old('description', $finalReport->description) }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Revisi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Upload File Revisi (Opsional)
                    </label>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 text-center
                              hover:border-gray-400 transition-colors">
                        <input type="file" name="file" id="file"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                               accept=".pdf,.doc,.docx">
                        <div class="space-y-2">
                            <i data-feather="upload-cloud" class="w-10 h-10 text-gray-400 mx-auto"></i>
                            <p class="text-gray-600">
                                <span class="font-medium text-blue-600">Klik untuk upload</span> revisi
                            </p>
                            <p class="text-xs text-gray-500">
                                Kosongkan jika tidak ingin mengganti file
                            </p>
                        </div>
                    </div>
                    @error('file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button type="submit"
                            class="w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white rounded-lg
                                   font-medium transition-colors flex items-center justify-center">
                        <i data-feather="save" class="w-4 h-4 mr-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
