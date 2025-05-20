@extends('layouts.company')

@section('title', 'Kelola Tugas')

@section('content')
<div class="container mx-auto max-w-6xl">
  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Kelola Tugas Magang</h1>
      <p class="text-gray-500 mt-1">Daftar semua tugas di perusahaan Anda</p>
    </div>
    <a href="{{ route('company.tasks.create') }}"
       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
      <i data-feather="plus" class="w-4 h-4 mr-2"></i>
      Tambah Tugas
    </a>
  </div>

  <!-- Table Section -->
  <div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tugas</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kegiatan</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tasks as $task)
          <tr class="border-t hover:bg-gray-50 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="font-medium text-gray-900">{{ $task->name }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">{{ $task->internship->title }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">
                {{ $task->deadline->translatedFormat('d F Y') }}
              </div>
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
                    $statusLabel = $statusText[$task->status] ?? 'Tidak Diketahui';
                @endphp
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                    {{ $statusLabel }}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('company.tasks.edit', $task->id) }}"
                   class="text-yellow-600 hover:text-yellow-800 transition-colors"
                   title="Edit">
                  <i data-feather="edit" class="w-5 h-5"></i>
                </a>
                <form action="{{ route('company.tasks.destroy', $task->id) }}" method="POST" class="inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-800 transition-colors"
                          onclick="return confirm('Hapus tugas ini?')" title="Hapus">
                    <i data-feather="trash-2" class="w-5 h-5"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    @if($tasks->hasPages())
    <div class="px-4 py-3 border-t border-gray-200">
      {{ $tasks->links() }}
    </div>
    @endif
  </div>
</div>
@endsection
