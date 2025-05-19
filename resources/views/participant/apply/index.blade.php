@extends('layouts.participant')

@section('title', 'Lamaran Saya')

@section('content')
<div class="container mx-auto max-w-3xl">
  <!-- Header -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Riwayat Lamaran Saya</h1>
      <p class="text-gray-500 mt-1">Lihat riwayat lamaran magang Anda</p>
    </div>
  </div>

  <!-- Flash Message -->
  @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
      <div class="flex items-center">
        <i data-feather="check-circle" class="w-5 h-5 mr-2"></i>
        <p>{{ session('success') }}</p>
      </div>
    </div>
  @endif

  @if($applications->isEmpty())
    <!-- Empty State -->
    <div class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-10 text-center">
      <i data-feather="briefcase" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
      <p class="text-gray-600 text-lg">Anda belum mengirimkan lamaran</p>
      <a href="{{ route('participant.internships.index') }}"
         class="mt-4 inline-block px-5 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
         Cari Lowongan
      </a>
    </div>
  @else
    <!-- Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perusahaan</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posisi</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lamar</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($applications as $lamar)
            <tr class="hover:bg-gray-50 transition">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <img class="h-10 w-10 rounded-full object-cover"
                       src="{{ $lamar->internship->company->logo ? asset('storage/'.$lamar->internship->company->logo) : asset('default-company.png') }}"
                       alt="Company Logo">
                  <div class="ml-3">
                    <div class="text-sm font-semibold text-gray-900">{{ $lamar->internship->company->name }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900">{{ $lamar->internship->title }}</div>
              </td>
              <td class="px-6 py-4 text-sm text-gray-500">
                {{ \Carbon\Carbon::parse($lamar->tanggal)->format('d M Y') }}
              </td>
              <td class="px-6 py-4">
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
                  $statusKey = strtolower($lamar->status);
                  $statusClass = $statusColors[$statusKey] ?? 'bg-gray-100 text-gray-800';
                  $statusLabel = $statusText[$statusKey] ?? ucfirst($lamar->status);
                @endphp
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                  {{ $statusLabel }}
                </span>
              </td>
              <td class="px-6 py-4 text-right text-sm font-medium">
                <a href="{{ route('participant.internships.show', $lamar->internship->id) }}"
                   class="text-blue-600 hover:text-blue-800 transition"
                   title="Lihat Detail">
                  <i data-feather="eye" class="w-5 h-5"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      @if($applications->hasPages())
      <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $applications->links() }}
      </div>
      @endif
    </div>
  @endif
</div>
@endsection
