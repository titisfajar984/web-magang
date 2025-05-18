@extends('layouts.company')

@section('title', 'Lowongan Magang Saya')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-semibold text-gray-800">Daftar Lowongan Magang</h3>
        <a href="{{ route('company.internships.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm rounded-lg shadow-md hover:from-indigo-600 hover:to-blue-600 transition-all duration-300 group">
           <i data-feather="plus-circle" class="w-5 h-5 transition-transform group-hover:rotate-90"></i>
           <span>Tambah Lowongan</span>
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Periode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Kuota</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($postings as $posting)
                <tr>
                    <td class="px-6 py-4">{{ $posting->judul }}</td>
                    <td class="px-6 py-4 text-gray-700">
                        {{ \Carbon\Carbon::parse($posting->periode_mulai)->format('d M Y') }} -
                        {{ \Carbon\Carbon::parse($posting->periode_selesai)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @php
                            $statusColors = [
                            'nonaktif' => 'bg-red-100 text-red-700',
                            'aktif' => 'bg-blue-100 text-blue-700',
                            ];
                            $statusClass = $statusColors[strtolower($posting->status)] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                            {{ ucfirst($posting->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-700">{{ $posting->kuota }}</td>
                    <td class="px-6 py-4 flex space-x-2 items-center">
                        <a href="{{ route('company.internships.show', $posting->id) }}"
                           class="text-blue-500 hover:text-blue-700" title="Detail">
                            <i data-feather="eye" class="w-5 h-5"></i>
                        </a>
                        <a href="{{ route('company.internships.edit', $posting->id) }}"
                           class="text-yellow-500 hover:text-yellow-700" title="Edit">
                            <i data-feather="edit" class="w-5 h-5"></i>
                        </a>
                        <form action="{{ route('company.internships.destroy', $posting->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin hapus?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                                <i data-feather="trash-2" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada lowongan magang.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
