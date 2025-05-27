@extends('layouts.company')

@section('title', 'Detail Logbook')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Detail Logbook</h1>
      <div class="flex flex-wrap items-center gap-x-4 gap-y-2 mt-2">
        <p class="text-sm text-gray-600 flex items-center">
          <i data-feather="user" class="w-4 h-4 mr-1.5"></i>
          <span class="font-medium">{{ $participant->user->name ?? '-' }}</span>
        </p>
        <p class="text-sm text-gray-600 flex items-center">
          <i data-feather="calendar" class="w-4 h-4 mr-1.5"></i>
          <span class="font-medium">{{ \Carbon\Carbon::parse($logbook->tanggal)->translatedFormat('d M Y, l') }}</span>
        </p>
      </div>
    </div>
    <a href="{{ url()->previous() }}"
       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
      <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
      Kembali
    </a>
  </div>

  <!-- Content Section -->
  <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
    <div class="p-6 md:p-8">
      <div class="prose max-w-none">
        <div class="mb-8">
          <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 mb-4">Deskripsi Kegiatan</h2>
          <div class="text-gray-700 whitespace-pre-line">{{ $logbook->deskripsi }}</div>
        </div>

        <div class="mb-8">
          <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 mb-4">Kendala</h2>
          <div class="text-gray-700 whitespace-pre-line">
            {{ $logbook->constraint ?? 'Tidak ada kendala yang dilaporkan.' }}
          </div>
        </div>
    </div>

  </div>
</div>
@endsection
