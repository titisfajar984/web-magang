@extends('layouts.participant')

@section('title', 'Profil')

@section('content')
<div class="bg-white shadow rounded-lg p-8 w-full">
    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-3xl font-semibold text-gray-800 mb-8">Profil</h1>

    <form action="{{ route('participant.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" value="{{ Auth::user()->name }}" readonly
                class="mt-1 block w-full bg-gray-100 text-gray-800 border border-gray-300 rounded-lg px-4 py-2 cursor-not-allowed">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" value="{{ Auth::user()->email }}" readonly
                class="mt-1 block w-full bg-gray-100 text-gray-800 border border-gray-300 rounded-lg px-4 py-2 cursor-not-allowed">
        </div>

        <div>
            <label for="no_telepon" class="block text-sm font-medium text-gray-700">No Telepon</label>
            <input type="text" name="no_telepon" id="no_telepon" required
                value="{{ old('no_telepon', $participant->no_telepon ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('no_telepon') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
            <input type="text" name="alamat" id="alamat" required
                value="{{ old('alamat', $participant->alamat ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('alamat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                value="{{ old('tanggal_lahir', $participant->tanggal_lahir ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('tanggal_lahir') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin"
                class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih --</option>
                <option value="Laki-laki" {{ old('jenis_kelamin', $participant->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $participant->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="university" class="block text-sm font-medium text-gray-700">Universitas</label>
            <input type="text" name="university" id="university"
                value="{{ old('university', $participant->university ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('university') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="program_studi" class="block text-sm font-medium text-gray-700">Program Studi</label>
            <input type="text" name="program_studi" id="program_studi"
                value="{{ old('program_studi', $participant->program_studi ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('program_studi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="transkrip" class="block text-sm font-medium text-gray-700">IPK</label>
            <input type="number" name="transkrip" id="transkrip" step="0.01" min="0" max="4"
                value="{{ old('transkrip', $participant->transkrip ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('transkrip') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="portofolio" class="block text-sm font-medium text-gray-700">Portofolio (link)</label>
            <input type="url" name="portofolio" id="portofolio"
                value="{{ old('portofolio', $participant->portofolio ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('portofolio') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
            @if(!empty($participant->foto))
                <img src="{{ asset('storage/' . $participant->foto) }}" alt="Foto participant" class="mb-2 w-32 h-32 object-cover rounded">
            @endif
            <input type="file" name="foto" id="foto" accept="image/*"
                class="mt-1 block w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('foto') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="cv" class="block text-sm font-medium text-gray-700">CV (PDF/DOC)</label>
            @if(!empty($participant->cv))
                <a href="{{ asset('storage/' . $participant->cv) }}" target="_blank" class="text-blue-600 underline">Lihat CV Saat Ini</a>
            @endif
            <input type="file" name="cv" id="cv" accept=".pdf,.doc,.docx"
                class="mt-1 block w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('cv') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="pt-4">
            <button type="submit"
                class="inline-flex items-center bg-blue-600 text-white font-medium px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
