@extends('layouts.company')

@section('title', 'Buat Tugas Baru')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Buat Tugas Baru</h1>
      <p class="text-gray-500 mt-1">Isi formulir untuk membuat tugas baru</p>
    </div>
    <a href="{{ isset($participant) ? route('company.tasks.index', ['participant_id' => $participant->id]) : route('company.tasks.index') }}"
       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
      <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
      Kembali
    </a>
  </div>

  <div class="bg-white shadow rounded-lg p-6">
    <form method="POST" action="{{ route('company.tasks.store') }}" class="space-y-6" enctype="multipart/form-data">
      @csrf

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
        @if(isset($participant))
            <input type="hidden" name="participant_id" value="{{ $participant->id }}">
            @php
                $application = $participant->applications()
                    ->where('status', 'accepted')
                    ->where('result_received', true)
                    ->whereHas('internship', fn($q) => $q->where('company_id', Auth::user()->companyProfile->id))
                    ->first();
            @endphp

            @if($application)
                <input type="hidden" name="application_id" value="{{ $application->id }}">
            @else
                <div class="text-red-500">Peserta ini belum memiliki aplikasi yang diterima di perusahaan Anda.</div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Peserta Magang</label>
                <div class="mt-1 p-3 bg-gray-50 rounded-md border border-gray-200">
                    <div class="flex items-center">
                        <img class="h-10 w-10 rounded-full object-cover mr-3"
                            src="{{ $participant->photo ? Storage::url($participant->photo) : asset('images/default-avatar.png') }}"
                            alt="{{ $participant->user->name }}">
                        <div>
                            <p class="font-medium text-gray-900">{{ $participant->user->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div>
                <label for="application_id" class="block text-sm font-medium text-gray-700 mb-2">Peserta Magang *</label>
                <select id="application_id" name="application_id" required
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <option value="">Pilih peserta</option>
                    @foreach($applications as $app)
                        <option value="{{ $app->id }}" {{ old('application_id') == $app->id ? 'selected' : '' }}>
                            {{ $app->participant->user->name }} ({{ $app->participant->user->email }})
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Nama Tugas *</label>
          <input type="text" name="name" value="{{ old('name') }}" required
                 class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
          <textarea name="description" rows="3"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Deadline *</label>
          <input type="date" name="deadline" value="{{ old('deadline') }}" required
                 class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Upload File *</label>
          <input type="file" name="file" required
                 class="form-input w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 @error('file') border-red-500 @enderror">
          @error('file')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
          <select name="status" required
                  class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            <option value="To Do" {{ old('status') == 'To Do' ? 'selected' : '' }}>Ditugaskan</option>
            <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
            <option value="Done" {{ old('status') == 'Done' ? 'selected' : '' }}>Selesai</option>
          </select>
        </div>
      </div>

      <div class="flex justify-end space-x-3 pt-6">
        <a href="{{ isset($participant) ? route('company.tasks.index', ['participant_id' => $participant->id]) : route('company.tasks.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Batal
        </a>
        <button type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          <i data-feather="save" class="w-4 h-4 mr-2"></i>
          Simpan Tugas
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
