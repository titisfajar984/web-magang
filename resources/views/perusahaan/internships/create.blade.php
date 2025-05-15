@extends('layouts.perusahaan')

@section('title', 'Tambah Lowongan Magang')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="mb-6">
    <h3 class="text-xl font-semibold text-gray-800">Tambah Lowongan Baru</h3>
    <p class="text-gray-500">Isi formulir berikut untuk menambahkan lowongan magang</p>
  </div>

  <div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('perusahaan.internships.store') }}" method="POST" class="space-y-6">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
          <input type="text" name="judul" id="judul" required
            class="w-full border border-gray-300 rounded p-2" value="{{ old('judul') }}">
        </div>

        <div>
          <label for="kuota" class="block text-sm font-medium text-gray-700">Kuota</label>
          <input type="number" name="kuota" id="kuota" required
            class="w-full border border-gray-300 rounded p-2" value="{{ old('kuota') }}">
        </div>

        <div>
          <label for="periode_mulai" class="block text-sm font-medium text-gray-700">Periode Mulai</label>
          <input type="date" name="periode_mulai" id="periode_mulai" required
            class="w-full border border-gray-300 rounded p-2" value="{{ old('periode_mulai') }}">
        </div>

        <div>
          <label for="periode_selesai" class="block text-sm font-medium text-gray-700">Periode Selesai</label>
          <input type="date" name="periode_selesai" id="periode_selesai" required
            class="w-full border border-gray-300 rounded p-2" value="{{ old('periode_selesai') }}">
        </div>

        <div>
          <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
          <select name="status" id="status" required class="w-full border border-gray-300 rounded p-2">
            <option value="">Pilih Status</option>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Tidak Aktif</option>
          </select>
        </div>

        <div>
          <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
          <input type="text" name="lokasi" id="lokasi" required
            class="w-full border border-gray-300 rounded p-2" value="{{ old('lokasi') }}">
        </div>
      </div>

      <div>
        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" rows="4"
          class="w-full border border-gray-300 rounded p-2" required>{{ old('deskripsi') }}</textarea>
      </div>

      <div class="text-right">
        <a href="{{ route('perusahaan.internships.index') }}" class="px-6 py-2 mr-3 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</a>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
          <i data-feather="save" class="w-4 h-4 inline mr-1"></i> Simpan Lowongan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
