@extends('layouts.company')

@section('title', 'Tambah Lowongan Magang')

@section('content')
<div class="container mx-auto max-w-3xl">
  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Tambah Lowongan Baru</h1>
      <p class="text-gray-500 mt-1">Isi formulir berikut untuk menambahkan lowongan magang</p>
    </div>
    <a href="{{ route('company.internships.index') }}"
       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
      <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
      Kembali
    </a>
  </div>

  <!-- Form Section -->
  <div class="bg-white shadow rounded-lg p-6">
    <form action="{{ route('company.internships.store') }}" method="POST" class="space-y-6">
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

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="title" class="block text-sm font-medium text-gray-700">Judul *</label>
          <input type="text" name="title" id="title" required
                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                 value="{{ old('title') }}">
        </div>

        <div>
          <label for="quota" class="block text-sm font-medium text-gray-700">Kuota *</label>
          <input type="number" name="quota" id="quota" required min="1"
                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                 value="{{ old('quota') }}">
        </div>

        <div>
          <label for="start_date" class="block text-sm font-medium text-gray-700">Periode Mulai *</label>
          <input type="date" name="start_date" id="start_date" required
                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                 value="{{ old('start_date') }}">
        </div>

        <div>
          <label for="end_date" class="block text-sm font-medium text-gray-700">Periode Selesai *</label>
          <input type="date" name="end_date" id="end_date" required
                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                 value="{{ old('end_date') }}">
        </div>

        <div>
          <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
          <select name="status" id="status" required
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            <option value="">Pilih Status</option>
            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
          </select>
        </div>

        <div class="md:col-span-2">
          <label for="location" class="block text-sm font-medium text-gray-700">Lokasi *</label>
          <input type="text" name="location" id="location" required
                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                 value="{{ old('location') }}">
        </div>

        <div class="md:col-span-2">
          <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi *</label>
          <textarea name="description" id="description" rows="5" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
        </div>
      </div>

      <div class="flex justify-end space-x-3 pt-6">
        <a href="{{ route('company.internships.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Batal
        </a>
        <button type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          <i data-feather="save" class="w-4 h-4 mr-2"></i>
          Simpan Lowongan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
