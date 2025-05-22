@extends('layouts.participant')

@section('title', 'Edit Logbook')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h3 class="text-xl font-semibold text-gray-800">Edit Logbook</h3>
      <p class="text-gray-500">Perbarui data logbook berikut</p>
    </div>
    <a href="{{ route('participant.logbooks.index') }}"
       class="text-gray-500 hover:text-gray-700 inline-flex items-center">
      <i data-feather="arrow-left" class="w-5 h-5 mr-1"></i> Kembali
    </a>
  </div>

  <div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route('participant.logbooks.update', $logbook) }}" class="space-y-6">
      @csrf
      @method('PUT')

      @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
          <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal *</label>
          <input type="date" name="tanggal" id="tanggal" required
                 value="{{ old('tanggal', $logbook->tanggal) }}"
                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div class="md:col-span-2">
          <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Kegiatan *</label>
          <textarea name="deskripsi" id="deskripsi" rows="4" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi', $logbook->deskripsi) }}</textarea>
        </div>

        <div class="md:col-span-2">
          <label for="constraint" class="block text-sm font-medium text-gray-700">Kendala (Opsional)</label>
          <textarea name="constraint" id="constraint" rows="3"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('constraint', $logbook->constraint) }}</textarea>
        </div>
      </div>

      <div class="flex justify-end space-x-3">
        <a href="{{ route('participant.logbooks.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Batal
        </a>
        <button type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          <i data-feather="save" class="w-4 h-4 mr-2"></i> Perbarui Logbook
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
