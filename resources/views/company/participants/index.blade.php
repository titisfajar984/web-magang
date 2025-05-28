@extends('layouts.company')

@section('title', 'Peserta Magang')

@section('content')
<div class="container mx-auto max-w-6xl">
  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Daftar Peserta Magang</h1>
      <p class="text-gray-500 mt-1">Peserta yang aktif di perusahaan Anda</p>
    </div>
  </div>

  <!-- Table Section -->
  <div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kegiatan</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($applications as $app)
          <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="font-medium text-gray-900">{{ $app->participant->user->name ?? '-' }}</div>
            </td>
            <td class="px-6 py-4">
              <div class="text-sm text-gray-900">{{ $app->internship->title ?? '-' }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                @php
                    $key   = strtolower($app->status);
                    $colors= ['pending'=>'bg-yellow-100 text-yellow-800','accepted'=>'bg-green-100 text-green-800','rejected'=>'bg-red-100 text-red-800'];
                    $texts = ['pending'=>'Menunggu','accepted'=>'Diterima','rejected'=>'Ditolak'];
                    $cls   = $colors[$key] ?? 'bg-gray-100 text-gray-800';
                    $lbl   = $texts[$key]  ?? ucfirst($app->status);
                    if($app->status === 'accepted' && $app->result_received){
                        $cls = 'bg-green-200 text-green-900';
                        $lbl = 'Diterima & Dikonfirmasi';
                    }
                @endphp
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $cls }}">
                    {{ $lbl }}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <a href="{{ route('company.tasks.index', $app->participant_id) }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-md transition h-[36px]">
                    <i data-feather="list" class="w-4 h-4 mr-1.5"></i>
                    Kelola Tugas
                </a>
                <a href="{{ route('company.logbooks.index', ['participant_id' => $app->participant_id]) }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-600 bg-green-50 hover:bg-green-100 rounded-md transition h-[36px]">
                    <i data-feather="book-open" class="w-4 h-4 mr-1.5"></i>
                    Kelola Logbooks
                </a>
                <a href="{{ route('company.finalreports.show', $app->participant_id) }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-purple-600 bg-purple-50 hover:bg-purple-100 rounded-md transition h-[36px]">
                        <i data-feather="file-text" class="w-4 h-4 mr-1.5"></i>
                        Laporan Akhir
                </a>
            </td>

          </tr>
          @empty
          <tr>
            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
              <div class="flex flex-col items-center justify-center py-8">
                <i data-feather="users" class="w-12 h-12 text-gray-400 mb-2"></i>
                <p>Belum ada peserta magang</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($applications->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
      {{ $applications->links() }}
    </div>
    @endif
  </div>
</div>
@endsection
