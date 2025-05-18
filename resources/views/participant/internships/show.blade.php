@extends('layouts.participant')

@section('title', 'Detail Intern')

@section('content')
<div class="bg-white min-h-screen">
    <div class="container mx-auto px-4 py-12 max-w-3xl">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('participant.internships.index') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Intern
            </a>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            <!-- Company Header -->
            <div class="p-8 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center gap-6">
                    <img src="{{ $intern->company && $intern->company->logo ? asset('storage/' . $intern->company->logo) : asset('default-company.png') }}"
                         class="w-20 h-20 rounded-lg border-2 border-white shadow-sm object-cover">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $intern->company->name }}</h1>
                        <p class="text-gray-600 mt-1">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $intern->company->alamat }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Job Details -->
            <div class="p-8">
                <!-- Title Section -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $intern->judul }}</h2>
                    <div class="flex items-center gap-4 text-gray-600">
                        <span class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            {{ \Carbon\Carbon::parse($intern->periode_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($intern->periode_selesai)->format('d M Y') }}
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-users mr-2"></i>
                            Kuota: {{ $intern->kuota }} participant
                        </span>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="mb-8">
                    <span class="px-4 py-2 rounded-full text-sm font-medium
                              {{ $intern->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($intern->status) }}
                    </span>
                </div>

                <!-- Description -->
                <div class="prose max-w-none mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Deskripsi Magang</h3>
                    {!! nl2br(e($intern->deskripsi)) !!}
                </div>

                <!-- Company Info -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Tentang Perusahaan</h3>
                    <div class="prose max-w-none">
                        {{ $intern->company->deskripsi ?? 'Tidak ada deskripsi perusahaan' }}
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="mt-8">
                    @if(auth()->user()->participantProfile)
                        @if($alreadyApplied)
                            <button class="w-full py-4 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed" disabled>
                                Sudah terdaftar
                            </button>
                        @else
                            <form action="{{ route('participant.internships.apply', $intern->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Jika ingin ada input file dan cover_letter, tampilkan disini -->
                                <button type="submit"
                                        class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all">
                                    Daftar Sekarang
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('participant.profile.edit') }}"
                           class="block w-full py-4 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold text-center transition-all">
                            Lengkapi Profil Terlebih Dahulu
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
