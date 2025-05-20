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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tugas</th>
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
                            <div class="text-gray-900">{{ $task->internship->title }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-900">{{ Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</div>
                            <div class="text-sm text-gray-500">{{ Carbon\Carbon::parse($task->deadline)->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $submission = $task->submissions->where('user_id', Auth::id())->first();
                                $status = $submission ? $submission->status : 'Belum Dikerjakan';
                                $statusColors = [
                                    'Submitted' => 'bg-green-100 text-green-800',
                                    'Late' => 'bg-yellow-100 text-yellow-800',
                                    'Belum Dikerjakan' => 'bg-gray-100 text-gray-800'
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('participant.tasks.show', $task->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
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
