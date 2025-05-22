@extends('layouts.participant')

@section('title', 'Logbook')

@section('content')
<div class="container mx-auto max-w-3xl">

  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Logbook</h1>
      <p class="text-gray-500 mt-1">Catatan harian kegiatan magangmu</p>
    </div>
    <a href="{{ route('participant.logbooks.create') }}"
       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
      <i data-feather="plus" class="w-4 h-4 mr-2"></i> Tambah Logbook
    </a>
  </div>

  <!-- Flash Message -->
  @if(session('success'))
  <div class="bg-green-100 text-green-800 px-4 py-2 rounded-md mb-4 border border-green-200">
    {{ session('success') }}
  </div>
  @endif

  <!-- Table Section -->
  <div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendala</th>
            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($logbooks as $logbook)
          <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap">
              {{ \Carbon\Carbon::parse($logbook->tanggal)->translatedFormat('d M Y') }}
            </td>
            <td class="px-6 py-4 whitespace-normal text-gray-800">
              {{ $logbook->deskripsi }}
            </td>
            <td class="px-6 py-4 whitespace-normal text-gray-800">
              {{ $logbook->constraint ?? '-' }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center">
              <div class="flex justify-center items-center space-x-3">
                <a href="{{ route('participant.logbooks.edit', $logbook) }}"
                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-yellow-600 bg-yellow-50 hover:bg-yellow-100 rounded-md transition h-[36px]"
                   title="Edit">
                  <i data-feather="edit" class="w-4 h-4 mr-1.5"></i>
                  Edit
                </a>

                <form method="POST" action="{{ route('participant.logbooks.destroy', $logbook) }}"
                      onsubmit="return confirm('Yakin ingin menghapus logbook ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-md transition h-[36px]"
                          title="Hapus">
                    <i data-feather="trash-2" class="w-4 h-4 mr-1.5"></i>
                    Hapus
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
              <div class="flex flex-col items-center justify-center py-8">
                <i data-feather="book-open" class="w-12 h-12 text-gray-400 mb-2"></i>
                <p>Belum ada logbook</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
