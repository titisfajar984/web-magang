@extends('layouts.company')

@section('title', 'Detail Lowongan Magang')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h3 class="text-xl font-semibold text-gray-800">Detail Lowongan Magang</h3>
      <p class="text-gray-500">Informasi lengkap tentang lowongan magang ini</p>
    </div>
    <a href="{{ route('company.internships.index') }}"
       class="text-gray-500 hover:text-gray-700 inline-flex items-center">
      <i data-feather="arrow-left" class="w-5 h-5 mr-1"></i> Kembali
    </a>
  </div>

  <div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $internship->title }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <h4 class="text-sm font-medium text-gray-500">Perusahaan</h4>
        <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->companyProfile->name ?? 'N/A' }}</p>
      </div>

      <div>
        <h4 class="text-sm font-medium text-gray-500">Lokasi</h4>
        <p class="mt-1 text-sm text-gray-900">{{ $internship->location }}</p>
      </div>

      <div>
        <h4 class="text-sm font-medium text-gray-500">Kuota</h4>
        <p class="mt-1 text-sm text-gray-900">{{ $internship->quota }}</p>
      </div>

      <div>
        <h4 class="text-sm font-medium text-gray-500">Status</h4>
        @php
          $statusColors = [
            'inactive' => 'bg-red-100 text-red-700',
            'active' => 'bg-blue-100 text-blue-700',
          ];
          $statusClass = $statusColors[strtolower($internship->status)] ?? 'bg-gray-100 text-gray-700';
        @endphp
        <span class="mt-1 px-2 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
          {{ ucfirst($internship->status) }}
        </span>
      </div>

      <div>
        <h4 class="text-sm font-medium text-gray-500">Periode Mulai</h4>
        <p class="mt-1 text-sm text-gray-900">
          {{ \Carbon\Carbon::parse($internship->start_date)->translatedFormat('d F Y') }}
        </p>
      </div>

      <div>
        <h4 class="text-sm font-medium text-gray-500">Periode Selesai</h4>
        <p class="mt-1 text-sm text-gray-900">
          {{ \Carbon\Carbon::parse($internship->end_date)->translatedFormat('d F Y') }}
        </p>
      </div>

      <div class="md:col-span-2">
        <h4 class="text-sm font-medium text-gray-500">Deskripsi</h4>
        <div class="mt-1 text-sm text-gray-900 whitespace-pre-line">
          {{ $internship->description }}
        </div>
      </div>
    </div>

    <div class="mt-6 flex space-x-3">
      <a href="{{ route('company.internships.edit', $internship->id) }}"
         class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-blue hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <i data-feather="edit" class="w-4 h-4 mr-2"></i> Edit
      </a>
      <form action="{{ route('company.internships.destroy', $internship->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                onclick="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')">
          <i data-feather="trash-2" class="w-4 h-4 mr-2"></i> Hapus
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
