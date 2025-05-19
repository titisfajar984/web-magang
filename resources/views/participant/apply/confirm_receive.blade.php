@extends('layouts.participant')

@section('title', 'Konfirmasi Penerimaan Hasil')

@section('content')
<div class="h-screen bg-gradient-to-br from-blue-50 to-teal-50 flex items-center justify-center px-4 overflow-hidden">
    <div class="bg-white rounded-2xl shadow-lg max-w-lg w-full p-6 mx-4 max-h-screen overflow-auto transition-all duration-300 hover:shadow-xl">
        <div class="flex items-center gap-4 mb-6">
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Konfirmasi Penerimaan Hasil</h2>
        </div>

        <div class="space-y-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Perusahaan:</span>
                <strong class="text-blue-600">{{ $application->internship->company->name }}</strong>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Posisi:</span>
                <strong>{{ $application->internship->title }}</strong>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Tanggal Lamar:</span>
                <strong>{{ \Carbon\Carbon::parse($application->tanggal)->format('d M Y') }}</strong>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Status:</span>
                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Diterima</span>
            </div>
        </div>

        <p class="mt-6 text-gray-600 text-center">Dengan mengkonfirmasi, Anda menyatakan telah menerima hasil magang</p>

        <form action="{{ route('participant.applications.receive', $application->id) }}" method="POST" class="mt-8">
            @csrf
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('participant.apply.index') }}"
                   class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all text-center">
                    Batalkan
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-gradient-to-br from-blue-600 to-teal-600 text-white rounded-xl hover:shadow-lg transition-all font-medium flex-1">
                    Konfirmasi Penerimaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
