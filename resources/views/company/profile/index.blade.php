@extends('layouts.company')

@section('title', 'Profil Perusahaan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-2xl font-bold mb-6">Profil Perusahaan</h1>

        <form method="POST" action="{{ route('company.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid gap-6 mb-6">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                        Nama Perusahaan
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $company->name) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">
                        Deskripsi
                    </label>
                    <textarea id="description" name="description" rows="4"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ old('description', $company->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block mb-2 text-sm font-medium text-gray-900">
                        Alamat
                    </label>
                    <input type="text" id="address" name="address" value="{{ old('address', $company->address) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="logo" class="block mb-2 text-sm font-medium text-gray-900">
                        Logo Perusahaan
                    </label>
                    <input type="file" id="logo" name="logo"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    @error('logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if($company->logo)
                    <div class="mt-2">
                        <span class="block text-sm font-medium text-gray-700 mb-1">Logo Saat Ini:</span>
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo Perusahaan" class="h-20">
                    </div>
                @endif
            </div>

            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
