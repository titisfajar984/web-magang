@extends('layouts.company')

@section('title', 'Daftar Lamaran Magang')

@section('content')
<div class="container mx-auto max-w-3xl">
  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Daftar Lamaran Magang</h1>
      <p class="text-gray-500 mt-1">Kelola semua lamaran magang yang masuk</p>
    </div>
  </div>

  <!-- Flash Message -->
  @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
      <div class="flex items-center">
        <i data-feather="check-circle" class="w-5 h-5 mr-2"></i>
        <p>{{ session('success') }}</p>
      </div>
    </div>
  @endif

  <!-- Table Section -->
  <div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Posisi
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Pelamar
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Tanggal Lamar
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Status
            </th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
              Aksi
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($applications as $application)
          <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="font-medium text-gray-900">{{ $application->internship->title ?? '-' }}</div>
            </td>
            <td class="px-6 py-4">
              <div class="text-gray-900">{{ $application->participant->user->name ?? '-' }}</div>
              <div class="text-sm text-gray-500">{{ $application->participant->university ?? '-' }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ $application->created_at->translatedFormat('d M Y') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                @php
                $statusColors = [
                    'pending' => 'bg-amber-100 text-amber-800',
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
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('company.apply.show', $application->id) }}"
                   class="text-blue-600 hover:text-blue-800 transition-colors"
                   title="Detail">
                  <i data-feather="eye" class="w-5 h-5"></i>
                </a>
                <form action="{{ route('company.apply.update', $application->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="status" onchange="this.form.submit()"
                            class="text-xs border rounded-md px-2 py-1 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option value="pending" {{ $application->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ $application->status === 'Accepted' ? 'selected' : '' }}>Diterima</option>
                        <option value="rejected" {{ $application->status === 'Rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
              <div class="flex flex-col items-center justify-center py-8">
                <i data-feather="inbox" class="w-12 h-12 text-gray-400 mb-2"></i>
                <p>Tidak ada lamaran magang</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($applications->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
      {{ $applications->links() }}
    </div>
    @endif
  </div>
</div>
@endsection
