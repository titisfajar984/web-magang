@extends('layouts.participant')

@section('title', 'Daftar Tugas')

@section('content')
<div class="container mx-auto max-w-full px-4">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Tugas Magang</h1>
            <p class="text-gray-500 mt-1">Tugas-tugas yang perlu Anda selesaikan</p>
        </div>
    </div>

    <!-- Content Section -->
    @if($tasks->isEmpty())
    <div class="bg-white shadow rounded-lg p-12 text-center max-w-full">
        <div class="max-w-md mx-auto">
            <div class="mb-4 text-gray-300">
                <i data-feather="check-circle" class="w-16 h-16 mx-auto"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada tugas saat ini</h3>
            <p class="text-gray-500">Anda belum memiliki tugas yang perlu diselesaikan</p>
        </div>
    </div>
    @else
    <div class="bg-white shadow rounded-lg overflow-hidden max-w-full">
        <div class="overflow-x-auto w-full">
            <table class="min-w-full divide-y divide-gray-200 table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tugas</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Magang</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($tasks as $task)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $task->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-900">{{ $task->application->internship->title}}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-900">{{ Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</div>
                            <div class="text-sm text-gray-500">{{ Carbon\Carbon::parse($task->deadline)->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'Done' => 'bg-green-100 text-green-800',
                                    'In Progress' => 'bg-yellow-100 text-yellow-800',
                                    'To Do' => 'bg-blue-100 text-blue-800',
                                ];
                                $statusText = [
                                    'Done' => 'Selesai',
                                    'In Progress' => 'Sedang Dikerjakan',
                                    'To Do' => 'Ditugaskan',
                                ];
                                $statusClass = $statusColors[$task->status] ?? 'bg-gray-100 text-gray-800';
                                $statusLabel = $statusText[$task->status] ?? $task->status;
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('participant.tasks.show', $task->id) }}"
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-md transition mr-2">
                                <i data-feather="eye" class="w-4 h-4 mr-1.5"></i>
                                Detail
                            </a>

                            @if($task->status === 'To Do')
                            <form action="{{ route('participant.tasks.start', $task->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-yellow-600 bg-yellow-50 hover:bg-yellow-100 rounded-md transition">
                                    <i data-feather="play" class="w-4 h-4 mr-1.5"></i>
                                    Kerjakan
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $tasks->links() }}
    </div>
    @endif
</div>
@endsection
