@extends('layouts.company')

@section('title', 'Detail Lowongan Magang')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">{{ $internship->judul }}</h2>

    <p class="mb-3 text-gray-700"><strong>Perusahaan:</strong> {{ Auth::user()->companyProfile->name ?? 'N/A' }}</p>
    <p class="mb-3 text-gray-700"><strong>Lokasi:</strong> {{ $internship->lokasi }}</p>
    <p class="mb-3 text-gray-700"><strong>Deskripsi:</strong><br>{!! nl2br(e($internship->deskripsi)) !!}</p>
    <p class="mb-3 text-gray-700"><strong>Kuota:</strong> {{ $internship->kuota }}</p>
    <p class="mb-3 text-gray-700"><strong>Periode Mulai:</strong> {{ \Carbon\Carbon::parse($internship->periode_mulai)->translatedFormat('d F Y') }}</p>
    <p class="mb-3 text-gray-700"><strong>Periode Selesai:</strong> {{ \Carbon\Carbon::parse($internship->periode_selesai)->translatedFormat('d F Y') }}</p>
    <p class="mb-3 text-gray-700"><strong>Status:</strong> {{ ucfirst($internship->status) }}</p>

    <a href="{{ route('company.internships.index') }}"
       class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
       Kembali
    </a>
  </div>
</div>
@endsection
