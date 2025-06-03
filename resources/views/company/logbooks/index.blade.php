@extends('layouts.company')

@section('title', 'Kelola Logbooks')

@section('content')
<div class="container mx-auto max-w-6xl">
  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">
        Kelola Logbooks Peserta
        @if(!empty($participant))
          - <span class="font-normal">{{ $participant->user->name }}</span>
        @endif
      </h1>
      @if(!empty($participant))
        <p class="text-gray-500 mt-1">
          Daftar logbook untuk {{ $participant->user->name }}
        </p>
      @endif
    </div>

    @if(!empty($participant))
      <div class="flex gap-2">
        <a href="{{ route('company.logbooks.export', ['participant_id' => $participant->id]) }}"
           class="inline-flex items-center px-4 py-2 border border-green-300 rounded-md shadow-sm text-sm font-medium text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
           title="Export Excel">
          <i data-feather="download" class="w-4 h-4 mr-2"></i>
          Export Excel
        </a>
        <a href="{{ route('company.participants.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
           title="Kembali ke Daftar Peserta">
          <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
          Kembali ke Daftar Peserta
        </a>
      </div>
    @endif
  </div>

  <!-- Table Section -->
  <div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse ($logbooks as $logbook)
            <tr class="hover:bg-gray-50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">
                  {{ \Carbon\Carbon::parse($logbook->tanggal)->translatedFormat('d M Y') }}
                </div>
                <div class="text-sm text-gray-500">
                  {{ \Carbon\Carbon::parse($logbook->tanggal)->translatedFormat('l') }}
                </div>
              </td>
              <td class="px-6 py-4 text-right">
                <a href="{{ route('company.logbooks.show', $logbook->id) }}"
                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-md transition"
                   title="Lihat Detail Logbook">
                  <i data-feather="eye" class="w-4 h-4 mr-1.5"></i>
                  Detail
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="2" class="px-6 py-4 text-center text-gray-500">
                Belum ada logbook untuk peserta ini.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($logbooks->hasPages())
      <div class="px-6 py-4 border-t border-gray-200">
        {{ $logbooks->withQueryString()->links() }}
      </div>
    @endif
  </div>
</div>
@endsection
