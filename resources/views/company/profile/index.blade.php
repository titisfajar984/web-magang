@extends('layouts.company')

@section('title', 'Profil')

@section('content')
<div class="bg-white shadow rounded-lg p-8 w-full">
    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-3xl font-semibold text-gray-800 mb-8">Profil</h1>
    <form action="{{ route('company.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">

        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama company</label>
            <input type="text" id="name" name="name" value="{{ old('name', $company->name) }}" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="5" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('deskripsi', $company->deskripsi) }}</textarea>
            @error('deskripsi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
            <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $company->alamat) }}" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('alamat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="logo" class="block text-sm font-medium text-gray-700">Logo company</label>
            <input type="file" id="logo" name="logo" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2">
            @error('logo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
                @if ($company->logo)
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">Logo Saat Ini:</p>
                <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo company" class="h-20">
            </div>
        @endif



        <div class="pt-4">
            <button type="submit" class="inline-flex items-center bg-blue-600 text-white font-medium px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
