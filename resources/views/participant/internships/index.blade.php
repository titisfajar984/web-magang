@extends('layouts.participant')

@section('title', 'Daftar Lowongan Magang')

@section('content')
<div class="container mx-auto max-w-3xl">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Lowongan Magang</h1>
            <p class="text-gray-500 mt-1">Temukan peluang magang terbaik untuk karirmu</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <form method="GET" action="{{ route('participant.internships.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
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

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                    <input type="text" name="location" value="{{ request('location') }}"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kuota Minimum</label>
                    <input type="number" name="quota" value="{{ request('quota') }}"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i data-feather="filter" class="w-4 h-4 mr-2"></i>
                        Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Content Section -->
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
        <div class="bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-4">
                    <img src="{{ $intern->company->logo ? asset('storage/'.$intern->company->logo) : asset('default-company.png') }}"
                        class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                    <div>
                        <h2 class="font-semibold text-gray-900">{{ $intern->company->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $intern->company->address }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
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

                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <i data-feather="calendar" class="w-4 h-4 mr-2"></i>
                    {{ $intern->start_date->format('d M Y') }} - {{ $intern->end_date->format('d M Y') }}
                </div>

                <a href="{{ route('participant.internships.show', $intern->id) }}"
                    class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Lihat Detail
                    <i data-feather="arrow-right" class="w-4 h-4 ml-2"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $interns->links() }}
    </div>
    @endif
</div>
@endsection
