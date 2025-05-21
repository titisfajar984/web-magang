@extends('layouts.company')

@section('title', 'Edit Tugas')

@section('content')
<div class="container mx-auto max-w-3xl">
  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Edit Tugas</h1>
      <p class="text-gray-500 mt-1">Perbarui informasi tugas</p>
    </div>
    <a href="{{ route('company.tasks.index') }}"
       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
      <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
      Kembali
    </a>
  </div>

  <!-- Form Section -->
  <div class="bg-white shadow rounded-lg p-6">
    <form method="POST" action="{{ route('company.tasks.update', $task->id) }}" class="space-y-6" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      @if($errors->any())
        <div class="rounded-md bg-red-50 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <i data-feather="alert-circle" class="h-5 w-5 text-red-400"></i>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan saat mengisi formulir</h3>
              <div class="mt-2 text-sm text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        </div>
      @endif

      <div class="grid grid-cols-1 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Lowongan Magang *</label>
          <select name="internship_id" required
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            @foreach($postings as $posting)
            <option value="{{ $posting->id }}" {{ (old('internship_id', $task->internship_id) == $posting->id) ? 'selected' : '' }}>
              {{ $posting->title }}
            </option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Nama Tugas *</label>
          <input type="text" name="name" value="{{ old('name', $task->name) }}" required
                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
          <textarea name="description" rows="3"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description', $task->description) }}</textarea>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Deadline *</label>
          <input type="date" name="deadline" value="{{ old('deadline', $task->deadline ? $task->deadline->format('Y-m-d') : '') }}" required
                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">File Tugas</label>

            @if($task->file_path)
                <div class="flex items-center space-x-3 mb-2">
                <i data-feather="file-text" class="w-5 h-5 text-gray-600"></i>
                <a href="{{ Storage::url($task->file_path) }}" target="_blank"
                    class="text-blue-600 hover:underline text-sm truncate max-w-xs">
                    {{ basename($task->file_path) }}
                </a>
                </div>
            @endif

            <input type="file" name="file" class="form-input @error('file') border-red-500 @enderror">
            @error('file')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Biarkan kosong jika tidak ingin mengganti file.</p>
        </div>


        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
          <select name="status" required
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            <option value="To Do" {{ old('status', $task->status) == 'To Do' ? 'selected' : '' }}>Ditugaskan</option>
            <option value="In Progress" {{ old('status', $task->status) == 'In Progress' ? 'selected' : '' }}>Dalam Proses</option>
            <option value="Done" {{ old('status', $task->status) == 'Done' ? 'selected' : '' }}>Selesai</option>
          </select>
        </div>
      </div>

      <div class="flex justify-end space-x-3 pt-6">
        <a href="{{ route('company.tasks.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Batal
        </a>
        <button type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          <i data-feather="save" class="w-4 h-4 mr-2"></i>
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
