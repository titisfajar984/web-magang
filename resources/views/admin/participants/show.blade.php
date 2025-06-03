@extends('layouts.admin')
@section('title', 'Detail Peserta')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h3 class="text-xl font-semibold text-gray-800">Detail Peserta</h3>
      <p class="text-gray-500">Informasi lengkap mengenai peserta</p>
    </div>
    <a href="{{ route('admin.participants.index') }}"
       class="text-gray-500 hover:text-gray-700 inline-flex items-center">
      <i data-feather="arrow-left" class="w-5 h-5 mr-1"></i> Kembali
    </a>
  </div>

  <div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-start">
      @if($participant->participantProfile && $participant->participantProfile->photo)
      <div class="flex-shrink-0 h-16 w-16 mr-4">
        <img class="h-16 w-16 rounded-full object-cover"
             src="{{ asset('storage/' . $participant->participantProfile->photo) }}"
             alt="{{ $participant->name }}">
      </div>
      @endif
      <div>
        <h2 class="text-2xl font-bold text-gray-800">{{ $participant->name }}</h2>
        <p class="text-gray-600">{{ $participant->email }}</p>
      </div>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <h4 class="text-sm font-medium text-gray-500">No. HP</h4>
        <p class="mt-1 text-sm text-gray-900">{{ $participant->participantProfile->phone_number ?? '-' }}</p>
      </div>
      <div>
        <h4 class="text-sm font-medium text-gray-500">Jenis Kelamin</h4>
        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($participant->participantProfile->gender ?? '-') }}</p>
      </div>
      <div>
        <h4 class="text-sm font-medium text-gray-500">Tanggal Lahir</h4>
        <p class="mt-1 text-sm text-gray-900">{{ $participant->participantProfile->birth_date ?? '-' }}</p>
      </div>
      <div>
        <h4 class="text-sm font-medium text-gray-500">Alamat</h4>
        <p class="mt-1 text-sm text-gray-900">{{ $participant->participantProfile->address ?? '-' }}</p>
      </div>
      <div>
        <h4 class="text-sm font-medium text-gray-500">Universitas</h4>
        <p class="mt-1 text-sm text-gray-900">{{ $participant->participantProfile->university ?? '-' }}</p>
      </div>
      <div>
        <h4 class="text-sm font-medium text-gray-500">Program Studi</h4>
        <p class="mt-1 text-sm text-gray-900">{{ $participant->participantProfile->study_program ?? '-' }}</p>
      </div>
      <div>
        <h4 class="text-sm font-medium text-gray-500">IPK</h4>
        <p class="mt-1 text-sm text-gray-900">{{ $participant->participantProfile->gpa ?? '-' }}</p>
      </div>
      <div>
        <h4 class="text-sm font-medium text-gray-500">Portfolio</h4>
        @if($participant->participantProfile->portfolio_url)
        <a href="{{ $participant->participantProfile->portfolio_url }}" class="text-blue-600 hover:underline text-sm" target="_blank">Lihat Portfolio</a>
        @else
        <p class="text-sm text-gray-900">-</p>
        @endif
      </div>
      <div>
        <h4 class="text-sm font-medium text-gray-500">CV</h4>
        @if($participant->participantProfile->cv)
        <a href="{{ asset('storage/' . $participant->participantProfile->cv) }}" class="text-blue-600 hover:underline text-sm" target="_blank">Unduh CV</a>
        @else
        <p class="text-sm text-gray-900">-</p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
