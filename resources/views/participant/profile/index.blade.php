@extends('layouts.participant')

@section('title', 'Profil')

@section('content')
<div class="container mx-auto max-w-3xl">
    <div class="bg-white rounded-lg shadow-md p-6">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(!$participant->isComplete())
            <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
                Profil Anda belum lengkap. Silakan lengkapi untuk bisa melihat dan melamar lowongan magang.
            </div>
        @endif

        <h1 class="text-2xl font-bold mb-6">Profil</h1>

        <form method="POST" action="{{ route('participant.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                    <input type="text" value="{{ auth()->user()->name }}" readonly
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                    <input type="email" value="{{ auth()->user()->email }}" readonly
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed">
                </div>

                <div>
                    <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900">Nomor Telepon</label>
                    <input type="text" id="phone_number" name="phone_number"
                        value="{{ old('phone_number', $participant->phone_number) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('phone_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                    <input type="text" id="address" name="address"
                        value="{{ old('address', $participant->address) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="birth_date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Lahir</label>
                    <input type="date" id="birth_date" name="birth_date"
                        value="{{ old('birth_date', $participant->birth_date) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('birth_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="gender" class="block mb-2 text-sm font-medium text-gray-900">Jenis Kelamin</label>
                    <select id="gender" name="gender"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="male" {{ old('gender', $participant->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ old('gender', $participant->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="university" class="block mb-2 text-sm font-medium text-gray-900">Kampus/Sekolah</label>
                    <input type="text" id="university" name="university"
                        value="{{ old('university', $participant->university) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('university')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="study_program" class="block mb-2 text-sm font-medium text-gray-900">Program Studi/Jurusan</label>
                    <input type="text" id="study_program" name="study_program"
                        value="{{ old('study_program', $participant->study_program) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('study_program')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="gpa" class="block mb-2 text-sm font-medium text-gray-900">IPK/Nilai Rata-rata</label>
                    <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="4"
                        value="{{ old('gpa', $participant->gpa) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('gpa')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="portfolio_url" class="block mb-2 text-sm font-medium text-gray-900">Portofolio (URL)</label>
                    <input type="url" id="portfolio_url" name="portfolio_url"
                        value="{{ old('portfolio_url', $participant->portfolio_url) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('portfolio_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="photo" class="block mb-2 text-sm font-medium text-gray-900">Foto Profil</label>
                    <input type="file" id="photo" name="photo"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    @error('photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($participant->photo)
                        <div class="mt-2">
                            <span class="block text-sm font-medium text-gray-700 mb-1">Foto Saat Ini:</span>
                            <img src="{{ asset('storage/' . $participant->photo) }}" alt="Foto Profil" class="h-20 rounded">
                        </div>
                    @endif
                </div>

                <div>
                    <label for="cv" class="block mb-2 text-sm font-medium text-gray-900">CV (PDF/DOC)</label>
                    <input type="file" id="cv" name="cv"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    @error('cv')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($participant->cv)
                        <div class="mt-2">
                            <span class="block text-sm font-medium text-gray-700 mb-1">CV Saat Ini:</span>
                            <a href="{{ asset('storage/' . $participant->cv) }}" target="_blank"
                                class="text-blue-600 hover:underline">Download CV</a>
                        </div>
                    @endif
                </div>
            </div>

            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
