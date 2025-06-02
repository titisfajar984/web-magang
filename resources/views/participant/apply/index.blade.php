@extends('layouts.participant')

@section('title', 'Lamaran')

@section('content')
<div class="container mx-auto max-w-3xl">
  <!-- Header -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Riwayat Lamaran</h1>
      <p class="text-gray-500 mt-1">Lihat riwayat lamaran magang Anda</p>
    </div>
  </div>

  <!-- Flash -->
  @foreach (['success','error'] as $msg)
    @if(session($msg))
      <div class="mb-6 p-4 bg-{{ $msg=='success'?'green':'red' }}-50 border-l-4 border-{{ $msg=='success'?'green':'red' }}-500 text-{{ $msg=='success'?'green':'red' }}-700 rounded">
        <div class="flex items-center">
          <i data-feather="{{ $msg=='success'?'check-circle':'x-circle' }}" class="w-5 h-5 mr-2"></i>
          <p>{{ session($msg) }}</p>
        </div>
      </div>
    @endif
  @endforeach

  @if($applications->isEmpty())
    <div class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-10 text-center">
      <i data-feather="briefcase" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
      <p class="text-gray-600 text-lg">Anda belum mengirimkan lamaran</p>
      <a href="{{ route('participant.internships.index') }}"
         class="mt-4 inline-block px-5 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
         Cari Lowongan
      </a>
    </div>
  @else
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            @php
                $showActionColumn = $applications->contains(function($lamar) {
                    return $lamar->status === 'accepted' && ! $lamar->result_received;
                });
            @endphp
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Perusahaan</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posisi</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Lamar</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              @if($showActionColumn)
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
              @endif
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($applications as $lamar)
            @php
              $key   = strtolower($lamar->status);
              $colors= ['pending'=>'bg-yellow-100 text-yellow-800','accepted'=>'bg-green-100 text-green-800','rejected'=>'bg-red-100 text-red-800'];
              $texts = ['pending'=>'Menunggu','accepted'=>'Diterima','rejected'=>'Ditolak'];
              $cls   = $colors[$key] ?? 'bg-gray-100 text-gray-800';
              $lbl   = $texts[$key]  ?? ucfirst($lamar->status);
              if($lamar->status==='accepted' && $lamar->result_received){
                  $cls = 'bg-green-200 text-green-900';
                  $lbl = 'Diterima & Dikonfirmasi';
              }
            @endphp
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap flex items-center">
                <img class="h-10 w-10 rounded-full object-cover"
                     src="{{ $lamar->internship->company->logo
                              ? asset('storage/'.$lamar->internship->company->logo)
                              : asset('default-company.png') }}"
                     alt="Logo">
                <span class="ml-3 text-sm font-semibold">{{ $lamar->internship->company->name }}</span>
              </td>
              <td class="px-6 py-4 text-sm">{{ $lamar->internship->title }}</td>
              <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($lamar->tanggal)->format('d M Y') }}</td>
              <td class="px-6 py-4">
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $cls }}">{{ $lbl }}</span>
              </td>
              @if($showActionColumn)
                <td class="px-6 py-4">
                <div class="flex items-center justify-end">
                    @if($lamar->status === 'accepted' && ! $lamar->result_received)
                    <a href="{{ route('participant.applications.confirm-receive', $lamar->id) }}" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 inline-block text-center">
                        Konfirmasi Hasil
                    </a>
                    @endif
                </div>
                </td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="bg-white px-4 py-3 border-t border-gray-200">
        {{ $applications->links() }}
      </div>
    </div>
  @endif
</div>
@endsection
