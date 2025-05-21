@extends('layouts.admin')

@section('title', 'Edit Data Pengguna')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h3 class="text-xl font-semibold text-gray-800">Edit Data Pengguna</h3>
      <p class="text-gray-500">Update data pengguna yang dipilih</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700 inline-flex items-center">
      <i data-feather="arrow-left" class="w-5 h-5 mr-1"></i> Kembali
    </a>
  </div>

  <div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6" novalidate>
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
          <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('name') border-red-500 @enderror"
            required
            autocomplete="name"
            maxlength="255"
          >
          @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
          <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('email') border-red-500 @enderror"
            required
            autocomplete="email"
            maxlength="255"
          >
          @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
          <input type="password" name="password" id="password"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('password') border-red-500 @enderror"
            autocomplete="new-password"
            minlength="8"
            placeholder="Kosongkan jika tidak ingin mengubah password"
          >
          @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
          <p class="text-xs text-gray-500 mt-1">Isi jika ingin mengganti password, minimal 8 karakter.</p>
        </div>

        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
          <input type="password" name="password_confirmation" id="password_confirmation"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            autocomplete="new-password"
            placeholder="Ulangi password baru jika diisi"
          >
        </div>

        <div>
          <label for="role" class="block text-sm font-medium text-gray-700">Role *</label>
          <select id="role" name="role"
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('role') border-red-500 @enderror"
            required
          >
            <option value="">Pilih Role</option>
            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="company" {{ old('role', $user->role) == 'company' ? 'selected' : '' }}>Perusahaan</option>
          </select>
          @error('role')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
      </div>

      <div class="text-right">
        <button type="submit"
          class="inline-flex items-center px-6 py-2 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition">
          <i data-feather="save" class="w-4 h-4 mr-2"></i> Edit
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
