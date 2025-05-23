@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container mx-auto">
  <div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-semibold text-gray-800">Daftar Pengguna</h3>
    <a href="{{ route('admin.users.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm rounded-lg shadow-md hover:from-indigo-600 hover:to-blue-600 transition-all duration-300 group">
      <i data-feather="plus-circle" class="w-5 h-5 transition-transform group-hover:rotate-90"></i>
      <span>Tambah Pengguna</span>
    </a>
  </div>

  <div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200" role="grid" aria-label="Daftar pengguna">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
          <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($users as $user)
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->email }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm">
            @php
                $roleColors = [
                    'admin' => 'bg-red-100 text-red-700',
                    'company' => 'bg-green-100 text-green-700',
                    'participant' => 'bg-blue-100 text-blue-700',
                ];

                $roleLabels = [
                    'admin' => 'Admin',
                    'company' => 'Perusahaan',
                    'participant' => 'Peserta',
                ];

                $roleKey = strtolower($user->role);
                $roleClass = $roleColors[$roleKey] ?? 'bg-gray-100 text-gray-700';
                $roleLabel = $roleLabels[$roleKey] ?? 'Tidak Diketahui';
            @endphp
            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $roleClass }}">
                {{ $roleLabel }}
            </span>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-center">
            <div class="flex justify-center items-center space-x-3">
                <a href="{{ route('admin.users.edit', $user->id) }}"
                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-yellow-600 bg-yellow-50 hover:bg-yellow-100 rounded-md transition h-[36px]"
                title="Edit Pengguna {{ $user->name }}">
                <i data-feather="edit" class="w-4 h-4 mr-1.5"></i>
                Edit
                </a>

                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                    onsubmit="return confirm('Hapus pengguna {{ $user->name }}?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-md transition h-[36px]"
                        title="Hapus Pengguna {{ $user->name }}">
                    <i data-feather="trash-2" class="w-4 h-4 mr-1.5"></i>
                    Hapus
                </button>
                </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
