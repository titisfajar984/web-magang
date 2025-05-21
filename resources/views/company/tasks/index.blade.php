@extends('layouts.company')

@section('title', 'Kelola Tugas')

@section('content')
<div class="container mx-auto max-w-6xl px-4 py-6">
  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">
        Kelola Tugas Magang
        @if(isset($participant))
          - <span class="font-normal">{{ $participant->user->name }}</span>
        @endif
      </h1>
      <p class="text-gray-500 mt-1">
        @if(isset($participant))
          Daftar tugas untuk {{ $participant->user->name }}
        @else
          Daftar semua tugas magang di perusahaan Anda
        @endif
      </p>
    </div>

    @unless(isset($participant))
    <div class="flex gap-3">
      <a href="{{ route('company.participants.index') }}"
         class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <i data-feather="users" class="w-4 h-4 mr-2"></i>
        Lihat Peserta
      </a>
      <a href="{{ route('company.tasks.create') }}"
         class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <i data-feather="plus" class="w-4 h-4 mr-2"></i>
        Tambah Tugas
      </a>
    </div>
    @else
    <a href="{{ route('company.participants.index') }}"
       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
      <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
      Kembali ke Daftar Peserta
    </a>
    @endunless
  </div>

  <!-- Table Section -->
  <div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tugas</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kegiatan</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse ($tasks as $task)
            <tr class="hover:bg-gray-50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="font-medium text-gray-900">{{ $task->name }}</div>
                <div class="text-sm text-gray-500 line-clamp-1">{{ $task->description }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ $task->internship->title ?? '-' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">
                  {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d F Y') }}
                  @if($task->deadline->isPast() && $task->status !== 'Done')
                    <span class="ml-1 text-xs text-red-500">(Terlewat)</span>
                  @endif
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                @php
                  $statusConfig = [
                    'Done' => ['color' => 'bg-green-100 text-green-800', 'label' => 'Selesai'],
                    'In Progress' => ['color' => 'bg-yellow-100 text-yellow-800', 'label' => 'Sedang Dikerjakan'],
                    'To Do' => ['color' => 'bg-blue-100 text-blue-800', 'label' => 'Ditugaskan'],
                  ];
                  $status = $statusConfig[$task->status] ?? ['color' => 'bg-gray-100 text-gray-800', 'label' => 'Tidak Diketahui'];
                @endphp
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $status['color'] }}">
                  {{ $status['label'] }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex items-center justify-end space-x-2">
                  @if($task->submissions->isNotEmpty())
                  <a href="{{ route('company.tasks.view-submission', $task->submissions->first()) }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-md transition h-[36px]"
                    title="Detail Jawaban">
                    <i data-feather="eye" class="w-4 h-4 mr-1.5"></i>
                    Jawaban
                  </a>
                  @endif
                  <a href="{{ route('company.tasks.edit', $task->id) }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-yellow-600 bg-yellow-50 hover:bg-yellow-100 rounded-md transition h-[36px]"
                    title="Edit">
                    <i data-feather="edit" class="w-4 h-4 mr-1.5"></i>
                    Edit
                  </a>
                  <form action="{{ route('company.tasks.destroy', $task->id) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit"
                      class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-md transition h-[36px]"
                      title="Hapus"
                      onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                      <i data-feather="trash-2" class="w-4 h-4 mr-1.5"></i>
                      Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                @if(isset($participant))
                  Belum ada tugas untuk {{ $participant->user->name }}.
                @else
                  Belum ada tugas di perusahaan Anda. <a href="{{ route('company.tasks.create') }}" class="text-blue-600 hover:text-blue-800">Buat tugas pertama</a>
                @endif
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($tasks->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
      {{ $tasks->links() }}
    </div>
    @endif
  </div>
</div>
@endsection
