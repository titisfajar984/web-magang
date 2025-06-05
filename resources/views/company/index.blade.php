@extends('layouts.company')
@section('title', 'Dashboard')
@section('content')
<div class="container mx-auto max-w-3xl">
    <h1 class="text-2xl font-semibold mb-6">Dashboard Perusahaan</h1>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Magang Aktif</p>
                    <p class="text-2xl font-semibold">{{ $stats['active_internships'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i data-feather="briefcase" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Lamaran</p>
                    <p class="text-2xl font-semibold">{{ $stats['total_applications'] }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i data-feather="file-text" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Tugas Tertunda</p>
                    <p class="text-2xl font-semibold">{{ $stats['pending_tasks'] }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i data-feather="alert-circle" class="w-6 h-6 text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Pelamar Hari Ini</p>
                    <p class="text-2xl font-semibold">{{ $stats['new_applicants'] }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i data-feather="user-plus" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Magang Aktif -->
    <div class="bg-white p-6 rounded-lg shadow-sm mb-8 whitespace-nowrap gap-2">
        <div class="flex flex-wrap items-center justify-between gap-x-4 gap-y-2 px-4">
            <h3 class="text-lg font-semibold">Magang Aktif Terbaru</h3>
            <a href="{{ route('company.internships.index') }}" class="text-blue-600 hover:text-blue-800 text-sm mt-2 sm:mt-0">
                Lihat Semua →
            </a>    
        </div>
        <div class="space-y-4 overflow-x-auto flex">
            @foreach($latest['internships'] as $internship)
            <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-lg flex-1 gap-6">
                <div>
                    <h4 class="font-medium">{{ $internship->title }}</h4>
                    <p class="text-sm text-gray-500">
                        {{ $internship->applications_count }} Lamaran •
                        {{ $internship->quota - $internship->applications_count }} Kuota Tersedia
                    </p>
                </div>
                <div class="text-sm text-gray-500">
                    Berakhir pada {{ $internship->end_date->format('d M Y') }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Lamaran Terbaru -->
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Lamaran Terbaru</h3>
            <a href="{{ route('company.apply.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                Lihat Semua →
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 whitespace-nowrap">
                <thead>
                    <tr class="text-left text-sm text-gray-500 border-b">
                        <th class="p-3">Pelamar</th>
                        <th class="p-3">Posisi</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latest['applications'] as $application)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3">{{ $application->participant->user->name }}</td>
                        <td class="p-3">{{ $application->internship->title }}</td>
                        <td class="p-3">
                            @php
                            $statusKey = strtolower($application->status);

                            $statusClasses = [
                                'pending'  => 'bg-yellow-100 text-yellow-800',
                                'accepted' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                            ];

                            $statusTexts = [
                                'pending'  => 'Menunggu',
                                'accepted' => 'Diterima',
                                'rejected' => 'Ditolak',
                            ];

                            // Jika status Accepted dan sudah konfirmasi (result_received), override class dan label
                            if ($application->status === 'Accepted' && !empty($application->result_received)) {
                                $badgeClass = 'bg-green-200 text-green-900';
                                $labelText = 'Diterima & Dikonfirmasi';
                            } else {
                                $badgeClass = $statusClasses[$statusKey] ?? 'bg-gray-100 text-gray-800';
                                $labelText = $statusTexts[$statusKey] ?? ucfirst($application->status);
                            }
                            @endphp

                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $badgeClass }}">
                            {{ $labelText }}
                            </span>
                        </td>
                        <td class="p-3 text-sm text-gray-500">
                            {{ $application->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
