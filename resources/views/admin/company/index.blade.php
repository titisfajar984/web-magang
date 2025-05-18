@extends('layouts.admin')
@section('title', 'Company Management')

@section('content')
<div class="container mx-auto">
  <div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-semibold text-gray-800">Company Management</h3>
    <a href="{{ route('admin.company.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm rounded-lg shadow-md hover:from-indigo-600 hover:to-blue-600 transition-all duration-300 group">
       <i data-feather="plus-circle" class="w-5 h-5 transition-transform group-hover:rotate-90"></i>
       <span>Add Company</span>
    </a>
  </div>

  <div class="bg-white shadow rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Account Owner</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($companies as $company)
        <tr>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
              @if($company->logo)
                <div class="flex-shrink-0 h-10 w-10">
                  <img class="h-10 w-10 rounded-full object-cover"
                       src="{{ asset('storage/' . $company->logo) }}"
                       alt="{{ $company->name }}">
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
            <div class="flex space-x-2">
              <a href="{{ route('admin.company.show', $company->id) }}"
                 class="text-blue-600 hover:text-blue-900">
                <i data-feather="eye" class="w-4 h-4"></i>
              </a>
              <a href="{{ route('admin.company.edit', $company->id) }}"
                 class="text-yellow-600 hover:text-yellow-900">
                <i data-feather="edit" class="w-4 h-4"></i>
              </a>
              <form action="{{ route('admin.company.destroy', $company->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this company?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900">
                  <i data-feather="trash-2" class="w-4 h-4"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
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
