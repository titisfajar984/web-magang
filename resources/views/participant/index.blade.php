@extends('layouts.participant')
@section('title', 'Dashboard')
@section('content')
<div class="container mx-auto max-w-full px-4">
    <h1 class="text-2xl font-semibold mb-6">Dashboard Peserta</h1>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Lamaran</p>
                    <p class="text-2xl font-semibold">{{ $stats['total_applications'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i data-feather="file-text" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Magang Aktif</p>
                    <p class="text-2xl font-semibold">{{ $stats['active_internships'] }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i data-feather="check-circle" class="w-6 h-6 text-green-600"></i>
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
                    <i data-feather="alert-triangle" class="w-6 h-6 text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Tugas Selesai</p>
                    <p class="text-2xl font-semibold">{{ $stats['completed_tasks'] }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i data-feather="clipboard" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Lamaran Terbaru -->
    <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Lamaran Terbaru</h3>
            <a href="{{ route('participant.apply.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                Lihat Semua →
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left text-sm text-gray-500 border-b">
                        <th class="p-3">Perusahaan</th>
                        <th class="p-3">Posisi</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latest['applications'] as $application)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3">{{ $application->internship->company->name }}</td>
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

                                if ($application->status === 'Accepted' && !empty($application->result_received)) {
                                    $badgeClass = 'bg-green-200 text-green-900';
                                    $labelText = 'Diterima & Dikonfirmasi';
                                } else {
                                    $badgeClass = $statusClasses[$statusKey] ?? 'bg-gray-100 text-gray-800';
                                    $labelText  = $statusTexts[$statusKey] ?? ucfirst($application->status);
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

    <!-- Tugas Mendatang -->
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Tugas Mendatang</h3>
            <a href="{{ route('participant.tasks.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                Lihat Semua →
            </a>
        </div>
        <div class="space-y-4 overflow-x-auto">
            @foreach($latest['tasks'] as $task)
            <div class="flex items-center justify-between whitespace-nowrap p-4 hover:bg-gray-50 rounded-lg border w-fit">
                <div>
                    <h4 class="font-medium">{{ $task->title }}</h4>
                    <p class="text-sm text-gray-500">
                        Deadline: {{ $task->deadline->format('d M Y') }}
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm {{ $task->deadline < now() ? 'text-red-600' : 'text-gray-500' }}">
                        {{ $task->deadline->diffForHumans() }}
                    </span>
                    @if($task->submissions->isNotEmpty())
                        <span class="px-2 py-1 text-sm rounded-full bg-blue-100 text-blue-600">
                            Telah dikirim
                        </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
