@extends('layouts.admin')

@section('title', 'Dashboard')
@section('content')
<div class="container mx-auto max-w-3xl">
    <h1 class="text-2xl font-semibold mb-6">Dashboard Admin</h1>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Perusahaan</p>
                    <p class="text-2xl font-semibold">{{ $stats['totalCompanies'] ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i data-feather="briefcase" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Magang Aktif</p>
                    <p class="text-2xl font-semibold">{{ $stats['activeInternships'] ?? 0 }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i data-feather="file-text" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Peserta</p>
                    <p class="text-2xl font-semibold">{{ $stats['totalParticipants'] ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i data-feather="users" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Pending Lamaran</p>
                    <p class="text-2xl font-semibold">{{ $stats['pendingApplications'] ?? 0 }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i data-feather="clock" class="w-6 h-6 text-yellow-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel & Data Terbaru -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Magang Terbaru -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold mb-4">Magang Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 whitespace-nowrap">
                    <thead>
                        <tr class="text-left text-sm text-gray-500 border-b border-gray-300">
                            <th class="pb-3 px-4 min-w-[120px]">Posisi</th>
                            <th class="pb-3 px-4 min-w-[120px]">Perusahaan</th>
                            <th class="pb-3 px-4 min-w-[60px] text-center">Kuota</th>
                            <th class="pb-3 px-4 min-w-[150px]">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latest['internships'] as $internship)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 break-words">{{ $internship->title }}</td>
                            <td class="px-4 break-words">{{ $internship->company->name }}</td>
                            <td class="text-center px-4">{{ $internship->quota }}</td>
                            <td class="text-xs text-gray-500 px-4">
                                {{ \Carbon\Carbon::parse($internship->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($internship->end_date)->format('d M') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Lamaran Terbaru -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold mb-4">Lamaran Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 whitespace-nowrap">
                    <thead>
                        <tr class="text-left text-sm text-gray-500 border-b">
                            <th class="pb-3">Peserta</th>
                            <th class="pb-3">Magang</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latest['applications'] ?? [] as $application)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3">{{ $application->participant->user->name }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($application->internship->title, 20) }}</td>
                            <td>
                                @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'accepted' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800'
                                ];
                                $statusText = [
                                    'pending' => 'Menunggu',
                                    'accepted' => 'Diterima',
                                    'rejected' => 'Ditolak'
                                ];
                                $statusClass = $statusColors[strtolower($application->status)] ?? 'bg-gray-100 text-gray-800';
                                $statusLabel = $statusText[strtolower($application->status)] ?? ucfirst($application->status);
                                @endphp

                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="text-sm text-gray-500">
                                {{ $application->created_at->format('d M Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data lamaran terbaru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
