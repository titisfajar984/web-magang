@extends('layouts.participant')

@section('title', 'Daftar Lowongan Magang')

@section('content')
<div class="bg-white min-h-screen">
    <div class="container mx-auto px-4 py-12">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Temukan Magang Impianmu</h1>
            <p class="text-lg text-gray-600">Jelajahi ratusan peluang magang dari perusahaan terkemuka</p>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-12 border border-gray-200">
            <form method="GET" action="{{ route('participant.internships.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Company Filter -->
                    <div>
                        <label for="company_id" class="block text-sm font-medium text-gray-700">Perusahaan</label>
                        <select id="company_id" name="company_id"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('company_id') border-red-500 @enderror">
                            <option value="">Semua Perusahaan</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('company_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date Filter: Mulai Magang -->
                    <div>
                        <label for="periode_start" class="block text-sm font-medium text-gray-700">Mulai Magang</label>
                        <input type="date" id="periode_start" name="periode_start" value="{{ request('periode_start') }}"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('periode_start') border-red-500 @enderror">
                        @error('periode_start')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date Filter: Selesai Magang -->
                    <div>
                        <label for="periode_end" class="block text-sm font-medium text-gray-700">Selesai Magang</label>
                        <input type="date" id="periode_end" name="periode_end" value="{{ request('periode_end') }}"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('periode_end') border-red-500 @enderror">
                        @error('periode_end')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full h-[42px] bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Content Section -->
        @if($interns->isEmpty())
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <div class="max-w-md mx-auto">
                    <div class="flex justify-center mb-6">
                        <i data-feather="briefcase" class="w-32 h-32 text-gray-300"></i>
                    </div>
                    <p class="text-gray-600 text-lg">Belum ada lowongan magang yang tersedia</p>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($interns as $intern)
                <div class="group bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-gray-100">
                    <!-- Company Header -->
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0">
                                <img src="{{ $intern->company && $intern->company->logo ? asset('storage/' . $intern->company->logo) : asset('default-company.png') }}"
                                    class="w-12 h-12 rounded-lg object-cover border border-gray-200"
                                    alt="Logo Perusahaan">
                            </div>

                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $intern->company->name ?? 'Perusahaan' }}</h3>
                                <p class="text-sm text-gray-500">{{ $intern->company->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Internship Details -->
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $intern->judul }}</h2>

                        <!-- Badges -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            <div class="flex items-center px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $intern->lokasi }}
                            </div>
                            <div class="flex items-center px-3 py-1 bg-green-50 text-green-700 rounded-full text-sm">
                                <i class="fas fa-users mr-2"></i>
                                Kuota: {{ $intern->kuota }}
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="mb-4">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-calendar-day text-blue-500"></i>
                                <span>{{ $intern->periode_mulai->format('d M Y') }} - {{ $intern->periode_selesai->format('d M Y') }}</span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('participant.internships.show', $intern->id) }}"
                           class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all">
                            Lihat Detail
                            <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-between">
                <div class="text-sm text-gray-600 mb-4 sm:mb-0">
                    Menampilkan <span class="font-medium">{{ $interns->firstItem() }}</span> sampai <span class="font-medium">{{ $interns->lastItem() }}</span> dari <span class="font-medium">{{ $interns->total() }}</span> lowongan magang
                </div>

                <nav class="flex items-center space-x-2">
                    {{-- Previous Page Link --}}
                    @if ($interns->onFirstPage())
                        <span class="px-3 py-1 rounded-md border border-gray-300 text-gray-400 cursor-not-allowed">
                            &laquo; Sebelumnya
                        </span>
                    @else
                        <a href="{{ $interns->previousPageUrl() }}" class="px-3 py-1 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">
                            &laquo; Sebelumnya
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($interns->getUrlRange(1, $interns->lastPage()) as $page => $url)
                        @if ($page == $interns->currentPage())
                            <span class="px-3 py-1 rounded-md border border-blue-500 bg-blue-500 text-white">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($interns->hasMorePages())
                        <a href="{{ $interns->nextPageUrl() }}" class="px-3 py-1 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">
                            Selanjutnya &raquo;
                        </a>
                    @else
                        <span class="px-3 py-1 rounded-md border border-gray-300 text-gray-400 cursor-not-allowed">
                            Selanjutnya &raquo;
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    </div>
</div>
@endsection
