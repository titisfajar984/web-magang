@extends('layouts.admin')
@section('title', 'Create Company')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h3 class="text-xl font-semibold text-gray-800">Create New Company</h3>
      <p class="text-gray-500">Fill the form below to add a new company</p>
    </div>
    <a href="{{ route('admin.company.index') }}"
       class="text-gray-500 hover:text-gray-700 inline-flex items-center">
      <i data-feather="arrow-left" class="w-5 h-5 mr-1"></i> Back
    </a>
  </div>

  <div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.company.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
          <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
          <label for="user_id" class="block text-sm font-medium text-gray-700">Account Owner *</label>
          <select name="user_id" id="user_id" required
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            <option value="">Select Account Owner</option>
            @foreach($users as $user)
              <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                {{ $user->name }} ({{ $user->email }})
              </option>
            @endforeach
          </select>
        </div>

        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Company Name *</label>
          <input type="text" name="name" id="name" value="{{ old('name') }}" required
                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
          <label for="logo" class="block text-sm font-medium text-gray-700">Company Logo</label>
          <input type="file" name="logo" id="logo"
                 class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>

        <div class="md:col-span-2">
          <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
          <textarea name="description" id="description" rows="4" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
        </div>

        <div class="md:col-span-2">
          <label for="address" class="block text-sm font-medium text-gray-700">Address *</label>
          <input type="text" name="address" id="address" value="{{ old('address') }}" required
                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>
      </div>

      <div class="mt-6 flex justify-end">
        <button type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          <i data-feather="save" class="w-4 h-4 mr-2"></i> Save Company
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
