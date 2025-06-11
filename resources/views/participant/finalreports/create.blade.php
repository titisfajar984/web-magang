@extends('layouts.participant')

@section('title', 'Buat Laporan')
@section('content')
<div class="container mx-auto max-w-3xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Laporan Akhir</h1>
            <p class="text-gray-500 mt-1">Isi formulir berikut untuk menambahkan laporan akhir magang Anda.</p>
        </div>
        <a href="{{ route('participant.finalreports.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('participant.finalreports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="application_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Magang <span class="text-red-500">*</span>
                    </label>
                    <select name="application_id" id="application_id" required
                        class="block w-full border border-gray-300 rounded-lg px-4 py-3
                               focus:border-blue-500 focus:ring-blue-500
                               @error('application_id') border-red-500 @enderror">
                        <option value="">Pilih Magang</option>
                        @foreach($applications as $app)
                            <option value="{{ $app->id }}" {{ old('application_id') == $app->id ? 'selected' : '' }}>
                                {{ $app->internship->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('application_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Laporan <span class="text-red-500">*</span>
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
                        File Laporan <span class="text-red-500">*</span>
                    </label>
                    <div id="uploadBox"
                         class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 text-center
                                hover:border-gray-400 transition-colors cursor-pointer"
                         >
                        <input type="file" name="file" id="file"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                               accept=".pdf,.doc,.docx" required>
                        <div id="uploadContent" class="space-y-2 pointer-events-none select-none">
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

                <div class="flex justify-end space-x-3 pt-6">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i data-feather="send" class="w-5 h-5 mr-2"></i> Kirim Laporan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    #uploadBox.has-file {
        border-color: #2563eb; /* biru */
        background-color: #eff6ff; /* biru muda */
    }
    #uploadBox.has-file i {
        color: #2563eb;
    }
    #uploadBox.has-file p {
        color: #2563eb;
    }

    /* Drag over effect */
    #uploadBox.dragover {
        border-color: #1e40af; /* lebih gelap saat drag over */
        background-color: #dbeafe;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if(window.feather) {
            window.feather.replace();
        }

        const fileInput = document.getElementById('file');
        const uploadBox = document.getElementById('uploadBox');
        const uploadContent = document.getElementById('uploadContent');

        // Ketika file dipilih
        fileInput.addEventListener('change', () => {
            if (fileInput.files && fileInput.files.length > 0) {
                uploadBox.classList.add('has-file');
                const fileName = fileInput.files[0].name;

                uploadContent.innerHTML = `
                    <i data-feather="check-circle" class="w-10 h-10 text-blue-600 mx-auto"></i>
                    <p class="text-blue-600 font-semibold truncate" title="${fileName}">${fileName}</p>
                    <p class="text-xs text-blue-600">File siap diupload</p>
                `;
                if(window.feather) window.feather.replace();
            } else {
                resetUploadBox();
            }
        });

        // Drag & drop styling
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadBox.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                uploadBox.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadBox.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                uploadBox.classList.remove('dragover');
            });
        });

        function resetUploadBox() {
            uploadBox.classList.remove('has-file');
            uploadContent.innerHTML = `
                <i data-feather="upload-cloud" class="w-10 h-10 text-gray-400 mx-auto"></i>
                <p class="text-gray-600">
                    <span class="font-medium text-blue-600">Klik untuk upload</span> atau drag & drop
                </p>
                <p class="text-xs text-gray-500">
                    Format: PDF/DOC/DOCX (Maks. 2MB)
                </p>
            `;
            if(window.feather) window.feather.replace();
        }
    });
</script>
@endsection
