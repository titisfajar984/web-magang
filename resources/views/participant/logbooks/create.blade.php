@extends('layouts.participant')

@section('title', 'Tambah Logbook')

@section('content')
<div class="container mx-auto max-w-3xl">
  <!-- Header Section -->
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

  <!-- Form Section -->
  <div class="bg-white shadow rounded-lg p-6">
    <form action="{{ route('participant.logbooks.store') }}" method="POST" class="space-y-6">
      @csrf

      @if($errors->any())
        <div class="rounded-md bg-red-50 p-4 mb-6">
          <div class="flex">
            <div class="flex-shrink-0">
              <i data-feather="alert-circle" class="h-5 w-5 text-red-400"></i>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan saat mengisi formulir</h3>
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
            <label for="application_id" class="block text-sm font-medium text-gray-700">Magang *</label>
            <select name="application_id" id="application_id" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @foreach($applications as $app)
                    <option value="">Pilih Magang</option>
                    <option value="{{ $app->id }}" {{ old('application_id') == $app->id ? 'selected' : '' }}>
                        {{ $app->internship->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
          <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal *</label>
          <input type="date" name="tanggal" id="tanggal" required
                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                 value="{{ old('tanggal') }}">
        </div>

        <div>
          <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Kegiatan *</label>
          <textarea name="deskripsi" id="deskripsi" rows="4" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi') }}</textarea>
        </div>

        <div>
          <label for="constraint" class="block text-sm font-medium text-gray-700">Kendala (Opsional)</label>
          <textarea name="constraint" id="constraint" rows="3"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('constraint') }}</textarea>
        </div>
      </div>

      <div class="flex justify-end space-x-3 pt-6">
        <a href="{{ route('participant.logbooks.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Batal
        </a>
        <button type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          <i data-feather="save" class="w-4 h-4 mr-2"></i>
          Simpan Logbook
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
