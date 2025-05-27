@extends('layouts.company')

@section('title', 'Detail Lowongan Magang')

@section('content')
<div class="container mx-auto max-w-3xl">
  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Detail Lowongan Magang</h1>
      <p class="text-gray-500 mt-1">Informasi lengkap tentang lowongan magang ini</p>
    </div>
    <a href="{{ route('company.internships.index') }}"
       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
      <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
      Kembali
    </a>
  </div>

  <!-- Content Section -->
  <div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-bold text-gray-900 mb-6">{{ $internship->title }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
      <div>
        <h3 class="text-sm font-medium text-gray-500">Perusahaan</h3>
        <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->companyProfile->name ?? 'N/A' }}</p>
      </div>

      <div>
        <h3 class="text-sm font-medium text-gray-500">Lokasi</h3>
        <p class="mt-1 text-sm text-gray-900">{{ $internship->location }}</p>
      </div>

      <div>
        <h3 class="text-sm font-medium text-gray-500">Kuota</h3>
        <p class="mt-1 text-sm text-gray-900">{{ $internship->quota }}</p>
      </div>

      <div>
        <h3 class="text-sm font-medium text-gray-500">Status</h3>
        @php
        $statusColors = [
            'inactive' => 'bg-red-100 text-red-800',
            'active' => 'bg-blue-100 text-blue-800',
        ];

        // Mapping status ke bahasa Indonesia
        $statusLabels = [
            'inactive' => 'Tidak Aktif',
            'active' => 'Aktif',
        ];

        $statusKey = strtolower($internship->status);
        $statusClass = $statusColors[$statusKey] ?? 'bg-gray-100 text-gray-800';
        $statusLabel = $statusLabels[$statusKey] ?? ucfirst($internship->status);
        @endphp

        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
        {{ $statusLabel }}
        </span>
      </div>

      <div>
        <h3 class="text-sm font-medium text-gray-500">Periode Mulai</h3>
        <p class="mt-1 text-sm text-gray-900">
          {{ \Carbon\Carbon::parse($internship->start_date)->translatedFormat('d F Y') }}
        </p>
      </div>

      <div>
        <h3 class="text-sm font-medium text-gray-500">Periode Selesai</h3>
        <p class="mt-1 text-sm text-gray-900">
          {{ \Carbon\Carbon::parse($internship->end_date)->translatedFormat('d F Y') }}
        </p>
      </div>
    </div>

    <div class="mb-8">
      <h3 class="text-sm font-medium text-gray-500">Deskripsi</h3>
      <div class="mt-1 text-sm text-gray-900 whitespace-pre-line">
        {{ $internship->description }}
      </div>
    </div>

    <div class="flex space-x-3 border-t border-gray-200 pt-6">
      <a href="{{ route('company.internships.edit', $internship->id) }}"
         class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <i data-feather="edit" class="w-4 h-4 mr-2"></i>
        Edit
      </a>
      <form action="{{ route('company.internships.destroy', $internship->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                onclick="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')">
          <i data-feather="trash-2" class="w-4 h-4 mr-2"></i>
          Hapus
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
