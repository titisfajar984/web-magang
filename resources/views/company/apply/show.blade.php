@extends('layouts.company')

@section('title', 'Detail Pelamar')

@section('content')
<div class="container mx-auto max-w-3xl">
  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Detail Pelamar Magang</h1>
      <p class="text-gray-500 mt-1">Informasi lengkap tentang pelamar dan lamarannya</p>
    </div>
    <a href="{{ route('company.apply.index') }}"
       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
      <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
      Kembali
    </a>
  </div>

  <!-- Internship Info Card -->
  <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
    <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50">
      <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
        <i data-feather="briefcase" class="w-5 h-5 mr-2 text-blue-600"></i>
        Informasi Magang
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <p class="text-sm font-medium text-gray-500">Posisi Magang</p>
          <p class="text-gray-900 font-medium">{{ $application->internship->title ?? '-' }}</p>
        </div>

        <div>
          <p class="text-sm font-medium text-gray-500">Status Lamaran</p>
                @php
                $statusColors = [
                    'pending' => 'bg-amber-100 text-amber-800',
                    'accepted' => 'bg-green-100 text-green-800',
                    'rejected' => 'bg-red-100 text-red-800'
                ];
                $statusText = [
                    'pending' => 'Menunggu',
                    'accepted' => 'Diterima',
                    'rejected' => 'Ditolak'
                ];
                $statusClass = $statusColors[strtolower($application->status)] ?? 'bg-gray-100 text-gray-800';
                $statusLabel = $statusText[strtolower($application->status)] ?? ucfirst($application->status);
                @endphp

                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                {{ $statusLabel }}
                </span>
        </div>

        <div>
          <p class="text-sm font-medium text-gray-500">Tanggal Lamar</p>
          <p class="text-gray-900 font-medium">{{ $application->created_at->translatedFormat('d F Y') }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Applicant Profile Card -->
  <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
    <div class="p-6">
      <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
        <i data-feather="user" class="w-5 h-5 mr-2 text-indigo-600"></i>
        Profil Pelamar
      </h2>

      <!-- Profile Header -->
      <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mb-8">
        <div class="relative">
          <img class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-md"
               src="{{ $application->participant->photo ? asset('storage/' . $application->participant->photo) : asset('images/default-profile.png') }}"
               alt="Foto Profil">
          <span class="absolute bottom-0 right-0 bg-blue-500 text-white rounded-full p-1 shadow-sm">
            <i data-feather="check" class="w-4 h-4"></i>
          </span>
        </div>

        <div class="flex-1">
          <h3 class="text-xl font-bold text-gray-900">{{ $application->participant->user->name ?? '-' }}</h3>
          <div class="flex flex-wrap items-center gap-x-4 gap-y-2 mt-2">
            <span class="flex items-center text-gray-600">
              <i data-feather="book" class="w-4 h-4 mr-2"></i>
              {{ $application->participant->university ?? '-' }}
            </span>
            <span class="flex items-center text-gray-600">
              <i data-feather="bookmark" class="w-4 h-4 mr-2"></i>
              {{ $application->participant->study_program ?? '-' }}
            </span>
          </div>
        </div>
      </div>

      <!-- Profile Details Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Personal Info -->
        <div class="space-y-4">
          <h4 class="font-medium text-gray-700 flex items-center">
            <i data-feather="user" class="w-4 h-4 mr-2 text-gray-500"></i>
            Informasi Pribadi
          </h4>
          <div class="space-y-3">
            <div>
              <p class="text-sm text-gray-500">Email</p>
              <p class="text-gray-900">{{ $application->participant->user->email ?? '-' }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Nomor HP</p>
              <p class="text-gray-900">{{ $application->participant->phone_number ?? '-' }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Jenis Kelamin</p>
              <p class="text-gray-900">
                {{ $application->participant->gender === 'male' ? 'Laki-laki' : ($application->participant->gender === 'female' ? 'Perempuan' : '-') }}
              </p>
            </div>
          </div>
        </div>

        <!-- Education Info -->
        <div class="space-y-4">
          <h4 class="font-medium text-gray-700 flex items-center">
            <i data-feather="book-open" class="w-4 h-4 mr-2 text-gray-500"></i>
            Pendidikan
          </h4>
          <div class="space-y-3">
            <div>
              <p class="text-sm text-gray-500">Kampus/Sekolah</p>
              <p class="text-gray-900">{{ $application->participant->university ?? '-' }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Program Studi/Jurusan</p>
              <p class="text-gray-900">{{ $application->participant->study_program ?? '-' }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">IPK/Nilai Rata-rata</p>
              <p class="text-gray-900">{{ $application->participant->gpa ?? '-' }}</p>
            </div>
          </div>
        </div>

        <!-- Documents -->
        <div class="space-y-4">
          <h4 class="font-medium text-gray-700 flex items-center">
            <i data-feather="file-text" class="w-4 h-4 mr-2 text-gray-500"></i>
            Dokumen
          </h4>
          <div class="space-y-3">
            @if($application->participant->cv)
              <a href="{{ asset('storage/' . $application->participant->cv) }}" target="_blank"
                 class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                <i data-feather="download" class="w-4 h-4 mr-2"></i>
                <span>Download CV</span>
              </a>
            @else
              <p class="text-gray-500">Tidak ada CV</p>
            @endif

            @if($application->participant->portfolio_url)
              <a href="{{ $application->participant->portfolio_url }}" target="_blank"
                 class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                <i data-feather="external-link" class="w-4 h-4 mr-2"></i>
                <span>Lihat Portofolio</span>
              </a>
            @else
              <p class="text-gray-500">Tidak ada portofolio</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
