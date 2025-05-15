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
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
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
                    'perusahaan' => 'bg-green-100 text-green-700',
                    'peserta' => 'bg-blue-100 text-blue-700',
                    ];
                    $roleClass = $roleColors[strtolower($user->role)] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $roleClass }}">
                    {{ ucfirst($user->role) }}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="flex space-x-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-700" title="Edit">
                    <i data-feather="edit" class="w-4 h-4"></i>
                    </a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                        <i data-feather="trash-2" class="w-4 h-4"></i>
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
