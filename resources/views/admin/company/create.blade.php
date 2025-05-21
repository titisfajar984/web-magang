@extends('layouts.admin')
@section('title', 'Tambah Perusahaan Baru')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h3 class="text-xl font-semibold text-gray-800">Tambah Perusahaan Baru</h3>
      <p class="text-gray-500">Isi formulir di bawah ini untuk menambahkan perusahaan baru</p>
    </div>
    <a href="{{ route('admin.company.index') }}"
       class="text-gray-500 hover:text-gray-700 inline-flex items-center" aria-label="Back to Company List">
      <i data-feather="arrow-left" class="w-5 h-5 mr-1"></i> Kembali
    </a>
  </div>

  <div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.company.store') }}" method="POST" enctype="multipart/form-data" novalidate class="space-y-6">
      @csrf

      @if($errors->any())
        <div class="p-4 bg-red-100 text-red-700 rounded-lg" role="alert">
          <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
          <label for="user_id" class="block text-sm font-medium text-gray-700">Pemilik akun*</label>
          <select name="user_id" id="user_id" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('user_id') border-red-500 @enderror"
            aria-required="true" aria-describedby="user_id-error">
            <option value="">Pilih Pemilik akun</option>
            @foreach($users as $user)
              <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                {{ $user->name }} ({{ $user->email }})
              </option>
            @endforeach
          </select>
          @error('user_id')
            <p id="user_id-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nama Perusahaan *</label>
          <input type="text" name="name" id="name" value="{{ old('name') }}" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('name') border-red-500 @enderror"
            aria-required="true" aria-describedby="name-error" maxlength="255">
          @error('name')
            <p id="name-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="logo" class="block text-sm font-medium text-gray-700">Logo Perusahaan</label>
          <input type="file" name="logo" id="logo" accept="image/*"
            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
            aria-describedby="logoHelp @error('logo') logo-error @enderror">
          <small id="logoHelp" class="text-gray-500">Optional. Allowed types: jpg, png, gif. Max size 2MB.</small>
          @error('logo')
            <p id="logo-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="md:col-span-2">
          <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi *</label>
          <textarea name="description" id="description" rows="4" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('description') border-red-500 @enderror"
            aria-required="true" aria-describedby="description-error">{{ old('description') }}</textarea>
          @error('description')
            <p id="description-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="md:col-span-2">
          <label for="address" class="block text-sm font-medium text-gray-700">Alamat *</label>
          <textarea name="address" id="address" rows="2" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('address') border-red-500 @enderror"
            aria-required="true" aria-describedby="address-error">{{ old('address') }}</textarea>
          @error('address')
            <p id="address-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="md:col-span-2 text-right">
          <button type="submit"
            class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition"
            aria-label="Simpan Perusahaan Baru">
            <i data-feather="save" class="w-4 h-4"></i> Simpan
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
