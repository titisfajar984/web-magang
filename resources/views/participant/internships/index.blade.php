@extends('layouts.participant')

@section('title', 'Daftar Lowongan Magang')

@section('content')
<div class="bg-gray-100 rounded-lg p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-800 mb-2">Temukan Magang Impianmu</h1>
        <p class="text-gray-600">Jelajahi ratusan peluang magang dari perusahaan terkemuka</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8 border border-gray-200">
        <form method="GET" action="{{ route('participant.internships.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Company Filter -->
                <div>
                    <label for="company_id" class="block text-sm font-medium text-gray-700 mb-1">Perusahaan</label>
                    <select id="company_id" name="company_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('company_id') border-red-500 @enderror">
                        <option value="">Semua Perusahaan</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location Filter -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <input type="text" id="location" name="location" value="{{ request('location') }}"
                        placeholder="Cari lokasi..."
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('location') border-red-500 @enderror">
                    @error('location')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quota Filter -->
                <div>
                    <label for="quota" class="block text-sm font-medium text-gray-700 mb-1">Kuota Minimum</label>
                    <input type="number" id="quota" name="quota" value="{{ request('quota') }}"
                        min="1"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('quota') border-red-500 @enderror">
                    @error('quota')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-all">
                        <i data-feather="filter" class="w-4 h-4"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>


    <!-- Content Section -->
    @if($interns->isEmpty())
        <div class="bg-white rounded-lg shadow-sm p-12 text-center border border-gray-200">
            <div class="max-w-md mx-auto">
                <div class="flex justify-center mb-4">
                    <i data-feather="briefcase" class="w-16 h-16 text-gray-300"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-700 mb-1">Belum ada lowongan magang</h3>
                <p class="text-gray-500 text-sm">Tidak ada lowongan magang yang tersedia saat ini</p>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($interns as $intern)
            <div class="group bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border border-gray-200">
                <!-- Company Header -->
                <div class="p-5 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <img src="{{ $intern->company && $intern->company->logo ? asset('storage/' . $intern->company->logo) : asset('default-company.png') }}"
                                class="w-10 h-10 rounded-lg object-cover border border-gray-200"
                                alt="Logo Perusahaan">
                        </div>

                        <div>
                            <h3 class="font-medium text-gray-800">{{ $intern->company->name ?? 'Perusahaan' }}</h3>
                            <p class="text-xs text-gray-500">{{ $intern->company->address ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Internship Details -->
                <div class="p-5">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $intern->title }}</h2>

                    <!-- Badges -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <div class="flex items-center px-2.5 py-0.5 bg-blue-50 text-blue-700 rounded-full text-xs">
                            <i data-feather="map-pin" class="w-3 h-3 mr-1"></i>
                            {{ $intern->location }}
                        </div>
                        <div class="flex items-center px-2.5 py-0.5 bg-green-50 text-green-700 rounded-full text-xs">
                            <i data-feather="users" class="w-3 h-3 mr-1"></i>
                            Kuota: {{ $intern->quota }}
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="mb-5">
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <i data-feather="calendar" class="w-3 h-3 text-blue-500"></i>
                            <span>{{ $intern->start_date->format('d M Y') }} - {{ $intern->end_date->format('d M Y') }}</span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <a href="{{ route('participant.internships.show', $intern->id) }}"
                       class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-all">
                        Lihat Detail
                        <i data-feather="arrow-right" class="w-4 h-4"></i>
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

            <nav class="flex items-center space-x-1">
                {{-- Previous Page Link --}}
                @if ($interns->onFirstPage())
                    <span class="px-3 py-1.5 rounded-md border border-gray-300 text-gray-400 text-sm cursor-not-allowed">
                        &laquo; Sebelumnya
                    </span>
                @else
                    <a href="{{ $interns->previousPageUrl() }}" class="px-3 py-1.5 rounded-md border border-gray-300 text-gray-700 text-sm hover:bg-gray-50">
                        &laquo; Sebelumnya
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($interns->getUrlRange(1, $interns->lastPage()) as $page => $url)
                    @if ($page == $interns->currentPage())
                        <span class="px-3 py-1.5 rounded-md border border-blue-500 bg-blue-500 text-white text-sm">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 rounded-md border border-gray-300 text-gray-700 text-sm hover:bg-gray-50">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($interns->hasMorePages())
                    <a href="{{ $interns->nextPageUrl() }}" class="px-3 py-1.5 rounded-md border border-gray-300 text-gray-700 text-sm hover:bg-gray-50">
                        Selanjutnya &raquo;
                    </a>
                @else
                    <span class="px-3 py-1.5 rounded-md border border-gray-300 text-gray-400 text-sm cursor-not-allowed">
                        Selanjutnya &raquo;
                    </span>
                @endif
            </nav>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace();
    });
</script>
@endsection
