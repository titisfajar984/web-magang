@extends('layouts.admin')

@section('title', 'Tambah Perusahaan Baru')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h3 class="text-xl font-semibold text-gray-800">Tambah Perusahaan Baru</h3>
      <p class="text-gray-500">Isi formulir berikut untuk menambahkan perusahaan baru</p>
    </div>
    <a href="{{ route('admin.company.index') }}"
       class="text-gray-500 hover:text-gray-700 inline-flex items-center">
      <i data-feather="arrow-left" class="w-5 h-5 mr-1"></i> Kembali
    </a>
  </div>

  <div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.company.store') }}" method="POST" class="space-y-6">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="user_id" class="block text-sm font-medium text-gray-700">Pemilik Akun *</label>
          <select name="user_id" id="user_id"
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('user_id') border-red-500 @enderror" required>
            <option value="">-- Pilih Pemilik Akun --</option>
            @foreach($users as $user)
              <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                {{ $user->name }} ({{ $user->email }})
              </option>
            @endforeach
          </select>
          @error('user_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nama Perusahaan *</label>
          <input type="text" name="name" id="name" value="{{ old('name') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('name') border-red-500 @enderror" required>
          @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="md:col-span-2">
          <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi *</label>
          <textarea name="deskripsi" id="deskripsi" rows="4"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('deskripsi') border-red-500 @enderror" required>{{ old('deskripsi') }}</textarea>
          @error('deskripsi')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="md:col-span-2">
          <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat *</label>
          <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('alamat') border-red-500 @enderror" required>
          @error('alamat')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
      </div>

      <div class="text-right">
        <button type="submit"
          class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
          <i data-feather="save" class="w-4 h-4 mr-2"></i> Simpan Data
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
