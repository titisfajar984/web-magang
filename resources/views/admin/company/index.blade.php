@extends('layouts.admin')
@section('title', 'Manajemen Perusahaan')

@section('content')
<div class="container mx-auto">
  <div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-semibold text-gray-800">Manajemen Perusahaan</h3>
    <a href="{{ route('admin.company.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm rounded-lg shadow-md hover:from-indigo-600 hover:to-blue-600 transition-all duration-300 group"
       aria-label="Tambah Perusahaan">
       <i data-feather="plus-circle" class="w-5 h-5 transition-transform group-hover:rotate-90"></i>
       <span>Tambah Perusahaan</span>
    </a>
  </div>

  <div class="bg-white shadow rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200" role="table" aria-label="Company List">
      <thead class="bg-gray-50">
        <tr>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemilik Akun</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @forelse($companies as $company)
        <tr>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
              @if($company->logo)
                <div class="flex-shrink-0 h-10 w-10">
                  <img class="h-10 w-10 rounded-full object-cover"
                       src="{{ asset('storage/' . $company->logo) }}"
                       alt="{{ e($company->name) }} Logo">
                </div>
              @endif
              <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">{{ $company->name }}</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ $company->user->name }}</div>
            <div class="text-sm text-gray-500">{{ $company->user->email }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <div class="flex space-x-2" role="group" aria-label="Company actions">
              <a href="{{ route('admin.company.show', $company->id) }}"
                 class="text-blue-600 hover:text-blue-900" aria-label="View {{ $company->name }}">
                <i data-feather="eye" class="w-4 h-4"></i>
              </a>
              <a href="{{ route('admin.company.edit', $company->id) }}"
                 class="text-yellow-600 hover:text-yellow-900" aria-label="Edit {{ $company->name }}">
                <i data-feather="edit" class="w-4 h-4"></i>
              </a>
              <form action="{{ route('admin.company.destroy', $company->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this company?')"
                    class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900" aria-label="Delete {{ $company->name }}">
                  <i data-feather="trash-2" class="w-4 h-4"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada data perusahaan</td>
        </tr>
        @endforelse
      </tbody>
    </table>

    @if($companies->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
      {{ $companies->links() }}
    </div>
    @endif
  </div>
</div>
@endsection
