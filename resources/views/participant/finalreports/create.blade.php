@extends('layouts.participant')

@section('title', 'Buat Laporan')
@section('content')
<div class="container mx-auto max-w-3xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Tambah Logbook</h1>
      <p class="text-gray-500 mt-1">Isi formulir berikut untuk menambahkan logbook harian Anda</p>
    </div>
    <a href="{{ route('participant.logbooks.index') }}"
       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
      <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
      Kembali
    </a>
  </div>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('participant.finalreports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Laporan
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" rows="4" required
                                  class="block w-full border border-gray-300 rounded-lg px-4 py-3
                                         focus:border-blue-500 focus:ring-blue-500
                                         @error('description') border-red-500 @enderror"
                                  placeholder="Jelaskan ringkasan laporan magang Anda...">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Maksimal 255 karakter</p>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            File Laporan
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 text-center
                                  hover:border-gray-400 transition-colors">
                            <input type="file" name="file" id="file"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                   accept=".pdf,.doc,.docx" required>
                            <div class="space-y-2">
                                <i data-feather="upload-cloud" class="w-10 h-10 text-gray-400 mx-auto"></i>
                                <p class="text-gray-600">
                                    <span class="font-medium text-blue-600">Klik untuk upload</span> atau drag & drop
                                </p>
                                <p class="text-xs text-gray-500">
                                    Format: PDF/DOC/DOCX (Maks. 2MB)
                                </p>
                            </div>
                        </div>
                        @error('file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alert Info -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i data-feather="alert-triangle" class="w-5 h-5 text-yellow-600 mr-2"></i>
                            <p class="text-sm text-yellow-800">
                                Pastikan file sudah final. Anda tidak dapat mengubah setelah submit!
                            </p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit"
                                class="w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white rounded-lg
                                       font-medium transition-colors flex items-center justify-center">
                            <i data-feather="send" class="w-4 h-4 mr-2"></i>
                            Submit Laporan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
