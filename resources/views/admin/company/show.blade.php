@extends('layouts.admin')
@section('title', 'Company Details')

@section('content')
<div class="container mx-auto max-w-3xl">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h3 class="text-xl font-semibold text-gray-800">Company Details</h3>
      <p class="text-gray-500">View detailed information about this company</p>
    </div>
    <a href="{{ route('admin.company.index') }}"
       class="text-gray-500 hover:text-gray-700 inline-flex items-center">
      <i data-feather="arrow-left" class="w-5 h-5 mr-1"></i> Back
    </a>
  </div>

  <div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-start">
      @if($company->logo)
      <div class="flex-shrink-0 h-16 w-16 mr-4">
        <img class="h-16 w-16 rounded-full object-cover"
             src="{{ asset('storage/' . $company->logo) }}"
             alt="{{ $company->name }}">
      </div>
      @endif
      <div>
        <h2 class="text-2xl font-bold text-gray-800">{{ $company->name }}</h2>
        <p class="text-gray-600">{{ $company->address }}</p>
      </div>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <h4 class="text-sm font-medium text-gray-500">Account Owner</h4>
        <p class="mt-1 text-sm text-gray-900">{{ $company->user->name }}</p>
        <p class="text-sm text-gray-500">{{ $company->user->email }}</p>
      </div>

      <div>
        <h4 class="text-sm font-medium text-gray-500">Description</h4>
        <p class="mt-1 text-sm text-gray-900">{{ $company->description }}</p>
      </div>
    </div>

    <div class="mt-6 flex space-x-3">
      <a href="{{ route('admin.company.edit', $company->id) }}"
        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <i data-feather="edit" class="w-4 h-4 mr-2 stroke-gray-700"></i> Edit
        </a>
    <form action="{{ route('admin.company.destroy', $company->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                onclick="return confirm('Are you sure you want to delete this company?')">
            <i data-feather="trash-2" class="w-4 h-4 mr-2 stroke-white"></i> Delete
        </button>
    </form>
    </div>
  </div>
</div>
@endsection
