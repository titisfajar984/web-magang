@extends('layouts.participant')

@section('title', 'Lowongan')

@section('content')
<div class="container mx-auto max-w-3xl">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Lowongan Magang</h1>
            <p class="text-gray-500 mt-1">Temukan peluang magang terbaik untuk karirmu</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <form method="GET" action="{{ route('participant.internships.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Perusahaan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Perusahaan</label>
                    <select name="company_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Perusahaan</option>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Lokasi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                    <input type="text" name="location" value="{{ request('location') }}"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Contoh: Jakarta">
                </div>

                <!-- Judul Lowongan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Lowongan</label>
                    <input type="text" name="title" value="{{ request('title') }}"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Contoh: Frontend Developer">
                </div>

                <!-- Tombol -->
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i data-feather="filter" class="w-4 h-4 mr-2"></i>
                        Filter
                    </button>
                    <a href="{{ route('participant.internships.index') }}"
                        class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Content -->
    @if($interns->isEmpty())
    <div class="bg-white shadow rounded-lg p-12 text-center">
        <div class="max-w-md mx-auto">
            <div class="mb-4 text-gray-300">
                <i data-feather="briefcase" class="w-16 h-16 mx-auto"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada lowongan tersedia</h3>
            <p class="text-gray-500">Silakan coba lagi dengan filter yang berbeda</p>
        </div>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($interns as $intern)
        <div class="bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-start gap-4">
                    <img src="{{ $intern->company->logo ? asset('storage/'.$intern->company->logo) : asset('default-company.png') }}"
                        class="w-12 h-12 rounded-lg object-cover border border-gray-200"
                        alt="Logo {{ $intern->company->name }}"
                        loading="lazy">
                    <div class="flex flex-col">
                        <h2 class="font-semibold text-gray-900 leading-tight">{{ $intern->company->name }}</h2>
                        <p class="text-sm text-gray-500 h-[48px] overflow-hidden text-ellipsis">{{ $intern->company->address }}</p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="p-6 flex flex-col flex-grow">
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $intern->title }}</h3>

                <div class="flex flex-wrap gap-2 mb-4">
                    <div class="flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                        <i data-feather="map-pin" class="w-4 h-4 mr-1"></i>
                        {{ $intern->location }}
                    </div>
                    <div class="flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                        <i data-feather="users" class="w-4 h-4 mr-1"></i>
                        {{ $intern->quota }} Kuota
                    </div>
                </div>

                <div class="text-sm text-gray-500 mb-2 flex items-center">
                    <i data-feather="calendar" class="w-4 h-4 mr-2"></i>
                    {{ optional($intern->start_date)->format('d M Y') }} - {{ optional($intern->end_date)->format('d M Y') }}
                </div>

                <div class="text-sm text-gray-500 mb-4">
                    Durasi:
                    {{ $intern->start_date && $intern->end_date ? $intern->start_date->diffInWeeks($intern->end_date) . ' minggu' : '-' }}
                </div>

                <div class="mt-auto">
                    <a href="{{ route('participant.internships.show', $intern->id) }}"
                        class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Lihat Detail
                        <i data-feather="arrow-right" class="w-4 h-4 ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $interns->links('vendor.pagination.tailwind') }}
    </div>
    @endif
</div>
@endsection
