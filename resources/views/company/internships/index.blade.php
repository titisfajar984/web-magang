@extends('layouts.company')

@section('title', 'Lowongan Magang Saya')

@section('content')
<div class="container mx-auto">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h3 class="text-xl font-semibold text-gray-800">Lowongan Magang Saya</h3>
      <p class="text-gray-500">Daftar lowongan magang yang telah dibuat</p>
    </div>
    <a href="{{ route('company.internships.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm rounded-lg shadow-md hover:from-indigo-600 hover:to-blue-600 transition-all duration-300 group">
       <i data-feather="plus-circle" class="w-5 h-5 transition-transform group-hover:rotate-90"></i>
       <span>Tambah Lowongan</span>
    </a>
  </div>

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
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">{{ $posting->title }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">
                {{ \Carbon\Carbon::parse($posting->start_date)->translatedFormat('d M Y') }} -
                {{ \Carbon\Carbon::parse($posting->end_date)->translatedFormat('d M Y') }}
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              @php
                $statusColors = [
                  'inactive' => 'bg-red-100 text-red-700',
                  'active' => 'bg-blue-100 text-blue-700',
                ];
                $statusClass = $statusColors[strtolower($posting->status)] ?? 'bg-gray-100 text-gray-700';
              @endphp
              <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                {{ ucfirst($posting->status) }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ $posting->quota }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <div class="flex items-center justify-end space-x-2">
                <a href="{{ route('company.internships.show', $posting->id) }}"
                   class="text-blue-600 hover:text-blue-900" title="Detail">
                  <i data-feather="eye" class="w-4 h-4"></i>
                </a>
                <a href="{{ route('company.internships.edit', $posting->id) }}"
                   class="text-yellow-600 hover:text-yellow-900" title="Edit">
                  <i data-feather="edit" class="w-4 h-4"></i>
                </a>
                <form action="{{ route('company.internships.destroy', $posting->id) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                    <i data-feather="trash-2" class="w-4 h-4"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
              Tidak ada lowongan magang.
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
