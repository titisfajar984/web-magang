@extends('layouts.company')

@section('title', 'Lowongan Magang Saya')

@section('content')
<div class="container mx-auto max-w-3xl">
  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Lowongan Magang Saya</h1>
      <p class="text-gray-500 mt-1">Daftar lowongan magang yang telah dibuat</p>
    </div>
    <a href="{{ route('company.internships.create') }}"
       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
      <i data-feather="plus" class="w-4 h-4 mr-2"></i>
      Tambah Lowongan
    </a>
  </div>

  <!-- Table Section -->
  <div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Judul
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Periode
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Status
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Kuota
            </th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
              Aksi
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($postings as $posting)
          <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="font-medium text-gray-900">{{ $posting->title }}</div>
            </td>
            <td class="px-6 py-4">
              <div class="text-sm text-gray-900">
                {{ \Carbon\Carbon::parse($posting->start_date)->translatedFormat('d M Y') }} -
                {{ \Carbon\Carbon::parse($posting->end_date)->translatedFormat('d M Y') }}
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              @php
                $statusColors = [
                  'inactive' => 'bg-red-100 text-red-800',
                  'active' => 'bg-blue-100 text-blue-800',
                ];
                $statusClass = $statusColors[strtolower($posting->status)] ?? 'bg-gray-100 text-gray-800';
              @endphp
              <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                {{ ucfirst($posting->status) }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ $posting->quota }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('company.internships.show', $posting->id) }}"
                   class="text-blue-600 hover:text-blue-800 transition-colors"
                   title="Detail">
                  <i data-feather="eye" class="w-5 h-5"></i>
                </a>
                <a href="{{ route('company.internships.edit', $posting->id) }}"
                   class="text-yellow-600 hover:text-yellow-800 transition-colors"
                   title="Edit">
                  <i data-feather="edit" class="w-5 h-5"></i>
                </a>
                <form action="{{ route('company.internships.destroy', $posting->id) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Hapus">
                    <i data-feather="trash-2" class="w-5 h-5"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
              <div class="flex flex-col items-center justify-center py-8">
                <i data-feather="briefcase" class="w-12 h-12 text-gray-400 mb-2"></i>
                <p>Tidak ada lowongan magang</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- @if($postings->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
      {{ $postings->links() }}
    </div>
    @endif --}}
  </div>
</div>
@endsection
