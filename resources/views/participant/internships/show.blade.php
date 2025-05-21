@extends('layouts.participant')

@section('title', 'Detail Intern')

@section('content')
<div class="container mx-auto max-w-full px-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $intern->title }}</h1>
            <p class="text-gray-500 mt-1">Program Magang di {{ $intern->company->name }}</p>
        </div>
        <a href="{{ route('participant.internships.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali
        </a>
    </div>

    <!-- Internship Card -->
    <div class="bg-white shadow rounded-lg p-6 mb-6 w-full">
        <!-- Company Info -->
        <div class="flex items-center gap-6 mb-6">
            <img src="{{ $intern->company && $intern->company->logo ? asset('storage/' . $intern->company->logo) : asset('default-company.png') }}"
                 class="w-20 h-20 rounded-lg border-2 border-white shadow-sm object-cover">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">{{ $intern->company->name }}</h2>
                <p class="text-gray-500 mt-1">
                    <i class="fas fa-map-marker-alt mr-2"></i>{{ $intern->company->address }}
                </p>
            </div>
        </div>

        <!-- Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Tanggal Magang</h3>
                <p class="mt-1 text-sm text-gray-900">
                    {{ \Carbon\Carbon::parse($intern->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($intern->end_date)->format('d M Y') }}
                </p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Kuota</h3>
                <p class="mt-1 text-sm text-gray-900">{{ $intern->quota }} peserta</p>
            </div>
        </div>

        <!-- Status -->
        <div class="mt-6">
            <h3 class="text-sm font-medium text-gray-500">Status</h3>
            <span class="mt-1 inline-block px-4 py-1 text-sm font-semibold rounded-full
                         {{ $intern->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                {{ ucfirst($intern->status) }}
            </span>
        </div>

        <!-- Description -->
        <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Deskripsi Program</h3>
            <div class="prose max-w-none text-gray-700">
                {!! nl2br(e($intern->description)) !!}
            </div>
        </div>

        <!-- Company Description -->
        <div class="mt-8 bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tentang Perusahaan</h3>
            <div class="prose max-w-none text-gray-600">
                {{ $intern->company->description ?? 'Tidak ada deskripsi perusahaan' }}
            </div>
        </div>

        <!-- CTA -->
        <div class="mt-8">
            @if(auth()->user()->participantProfile)
                @if($alreadyApplied)
                    <button class="w-full py-4 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed" disabled>
                        Sudah terdaftar
                    </button>
                @else
                    <a href="{{ route('participant.internships.confirmation', $intern->id) }}"
                       onclick="return confirmRegistration()"
                       class="block w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-center transition">
                        Daftar Sekarang
                    </a>
                @endif
            @else
                <a href="{{ route('participant.profile.edit') }}"
                   class="block w-full py-4 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold text-center transition">
                    Lengkapi Profil Terlebih Dahulu
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
