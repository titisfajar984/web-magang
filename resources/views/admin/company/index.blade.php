@extends('layouts.admin')
@section('title', 'Manajemen Perusahaan')

@section('content')
<div class="container mx-auto">
  <div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-semibold text-gray-800">Daftar Profil Perusahaan</h3>
        <a href="{{ route('admin.company.create') }}"
        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm rounded-lg shadow-md hover:from-indigo-600 hover:to-blue-600 transition-all duration-300 group">
        <i data-feather="plus-circle" class="w-5 h-5 transition-transform group-hover:rotate-90"></i>
        <span>Tambah Perusahaan</span>
        </a>
  </div>

  <div class="bg-white shadow rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Nama Perusahaan</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Pemilik Akun</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($companies as $company)
        <tr>
            <td class="px-6 py-4">{{ $company->name }}</td>
            <td class="px-6 py-4">{{ $company->user->name }}</td>
            <td class="px-6 py-4 flex space-x-2">
                <a href="{{ route('admin.company.show', $company->id) }}" class="text-blue-500 hover:text-blue-700" title="Detail">
                    <i data-feather="eye" class="w-4 h-4"></i>
                </a>
                <a href="{{ route('admin.company.edit', $company->id) }}" class="text-yellow-500 hover:text-yellow-700" title="Edit">
                    <i data-feather="edit" class="w-4 h-4"></i>
                </a>
                <form action="{{ route('admin.company.destroy', $company->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                    <i data-feather="trash-2" class="w-4 h-4"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
