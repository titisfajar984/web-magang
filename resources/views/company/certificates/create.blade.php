@extends('layouts.company')

@section('title', $application->certificate ? 'Detail Sertifikat' : 'Upload Sertifikat')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">
        {{ $application->certificate ? 'Detail Sertifikat' : 'Upload Sertifikat' }}
      </h1>
      <p class="text-gray-500 mt-1">
        {{ $application->certificate ? 'Detail sertifikat peserta magang' : 'Unggah sertifikat untuk peserta magang' }}
      </p>
    </div>
    <a href="{{ route('company.participants.index') }}"
       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
      <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
      Kembali
    </a>
  </div>

  <div class="bg-white shadow rounded-lg p-6">
    @if($application->certificate)
    <div class="mb-6 p-4 rounded-md bg-yellow-50 border border-yellow-300 text-yellow-800 flex items-start">
        <i data-feather="info" class="w-5 h-5 mr-3 text-yellow-500 mt-1"></i>
        <div>
            <p class="font-medium">Sertifikat sudah diunggah.</p></div>
        </div>
        <div class="grid grid-cols-1 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Peserta</label>
            <p class="text-gray-900 font-semibold">{{ $application->participant->user->name }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Judul Magang</label>
            <p class="text-gray-900">{{ $application->internship->title }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status Sertifikat</label>
            <div class="flex items-center">
              <i data-feather="check-circle" class="w-5 h-5 text-green-500 mr-2"></i>
              <span class="text-green-600 font-medium">Sertifikat Telah Dibuat</span>
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Upload</label>
            <p class="text-gray-900">
              {{ $application->certificate->created_at->format('d F Y H:i') }}
            </p>
          </div>
        </div>

        <div class="flex justify-end space-x-3 pt-6">
          <a href="{{ Storage::url($application->certificate->file_path) }}" target="_blank"
             class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i data-feather="download" class="w-4 h-4 mr-2"></i>
            Unduh Sertifikat
          </a>
        </div>
      </div>
    @else
    <div class="mb-6 p-4 rounded-md bg-yellow-50 border border-yellow-300 text-yellow-800 flex items-start">
        <i data-feather="info" class="w-5 h-5 mr-3 text-yellow-500 mt-1"></i>
        <div>
            <p class="text-sm">Sertifikat hanya bisa diunggah satu kali dan tidak dapat diubah. Pastikan file yang diunggah sudah benar.</p>
        </div>
    </div>
      <form method="POST" action="{{ route('company.certificates.store', $application->participant_id) }}" class="space-y-6" enctype="multipart/form-data">
        @csrf

        @if($errors->any())
          <div class="rounded-md bg-red-50 p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <i data-feather="alert-circle" class="h-5 w-5 text-red-400"></i>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan saat mengunggah</h3>
                <div class="mt-2 text-sm text-red-700">
                  <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>
        @endif

        <div class="grid grid-cols-1 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Peserta</label>
            <p class="text-gray-900 font-semibold">{{ $application->participant->user->name }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Judul Magang</label>
            <p class="text-gray-900">{{ $application->internship->title }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Sertifikat (PDF) *</label>
            <input type="file" name="certificate" required
                   class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('certificate') border-red-500 @enderror">
            @error('certificate')
              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div class="flex justify-end space-x-3 pt-6">
          <a href="{{ route('company.participants.index') }}"
             class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Batal
          </a>
          <button type="submit"
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i data-feather="upload" class="w-4 h-4 mr-2"></i>
            Upload Sertifikat
          </button>
        </div>
      </form>
    @endif
  </div>
</div>
@endsection
