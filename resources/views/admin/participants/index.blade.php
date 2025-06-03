@extends('layouts.admin')
@section('title', 'Manajemen Peserta')

@section('content')
<div class="container mx-auto">
  <div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-semibold text-gray-800">Manajemen Peserta</h3>
    <a href="{{ route('admin.participants.export') }}"
       class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm8 10v-4m0 0l-2 2m2-2l2 2" />
      </svg>
      Export Excel
    </a>
  </div>

  <div class="bg-white shadow rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200" role="table" aria-label="Participant List">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Universitas</th>
          <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @forelse($participants as $participant)
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $participant->name }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $participant->email }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $participant->participantProfile->university ?? '-' }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-center">
            <a href="{{ route('admin.participants.show', $participant->id) }}"
               class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-md transition h-[36px]">
              <i data-feather="eye" class="w-4 h-4 mr-1.5"></i> Lihat
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada peserta</td>
        </tr>
        @endforelse
      </tbody>
    </table>

    @if($participants->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
      {{ $participants->links() }}
    </div>
    @endif
  </div>
</div>
@endsection
