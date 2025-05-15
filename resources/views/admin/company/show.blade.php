@extends('layouts.admin')
@section('title', 'Detail Profil Perusahaan')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">{{ $company->name }}</h2>
    <p class="mb-2"><strong>Deskripsi:</strong> {{ $company->deskripsi }}</p>
    <p class="mb-2"><strong>Alamat:</strong> {{ $company->alamat }}</p>
    <p class="mb-2"><strong>Pemilik Akun:</strong> {{ $company->user->name }} ({{ $company->user->email }})</p>

    <a href="{{ route('admin.company.index') }}" class="mt-4 inline-block text-blue-600">← Kembali ke Daftar</a>
  </div>
</div>
@endsection
