@extends('layouts.company')

@section('title', 'Edit Lowongan Magang')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="mb-6">
    <h3 class="text-xl font-semibold text-gray-800">Edit Lowongan</h3>
    <p class="text-gray-500">Perbarui informasi lowongan magang berikut</p>
  </div>

  <div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('company.internships.update', $internship->id) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
          <input type="text" name="judul" id="judul" required
            class="w-full border border-gray-300 rounded p-2"
            value="{{ old('judul', $internship->judul) }}">
          @error('judul') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="kuota" class="block text-sm font-medium text-gray-700">Kuota</label>
          <input type="number" name="kuota" id="kuota" required min="1"
            class="w-full border border-gray-300 rounded p-2"
            value="{{ old('kuota', $internship->kuota) }}">
          @error('kuota') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="periode_mulai" class="block text-sm font-medium text-gray-700">Periode Mulai</label>
          <input type="date" name="periode_mulai" id="periode_mulai" required
            class="w-full border border-gray-300 rounded p-2"
            value="{{ old('periode_mulai', \Carbon\Carbon::parse($internship->periode_mulai)->format('Y-m-d')) }}">
          @error('periode_mulai') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="periode_selesai" class="block text-sm font-medium text-gray-700">Periode Selesai</label>
          <input type="date" name="periode_selesai" id="periode_selesai" required
            class="w-full border border-gray-300 rounded p-2"
            value="{{ old('periode_selesai', \Carbon\Carbon::parse($internship->periode_selesai)->format('Y-m-d')) }}">
          @error('periode_selesai') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
          <select name="status" id="status" required class="w-full border border-gray-300 rounded p-2">
            <option value="aktif" {{ old('status', $internship->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ old('status', $internship->status) == 'nonaktif' ? 'selected' : '' }}>Tidak Aktif</option>
          </select>
          @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="md:col-span-2">
          <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
          <input type="text" name="lokasi" id="lokasi" required
            class="w-full border border-gray-300 rounded p-2"
            value="{{ old('lokasi', $internship->lokasi) }}">
          @error('lokasi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="md:col-span-2">
          <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
          <textarea name="deskripsi" id="deskripsi" rows="4" required
            class="w-full border border-gray-300 rounded p-2">{{ old('deskripsi', $internship->deskripsi) }}</textarea>
          @error('deskripsi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="text-right">
        <a href="{{ route('company.internships.index') }}" class="px-6 py-2 mr-3 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</a>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
          <i data-feather="save" class="w-4 h-4 inline mr-1"></i> Perbarui Lowongan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
