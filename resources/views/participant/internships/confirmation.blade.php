@extends('layouts.participant')

@section('title', 'Konfirmasi Pendaftaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-lg max-w-2xl w-full p-8 mx-4 transition-all duration-300 hover:shadow-xl">
        <div class="flex items-center gap-4 mb-6">
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">Konfirmasi Pendaftaran Magang</h2>
        </div>

        <div class="space-y-6 text-gray-700">
            <p class="leading-relaxed">
                Dengan melanjutkan, Anda menyetujui ketentuan berikut:
            </p>
            <div class="bg-orange-50 p-4 rounded-xl border border-orange-100">
                <ul class="space-y-3">
                    <li class="flex items-start gap-2">
                        <span class="text-orange-500 mt-1">•</span>
                        <span>Mengirim lamaran ke <strong class="text-blue-600">{{ $intern->company->name }}</strong></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-orange-500 mt-1">•</span>
                        <span>Data profil sudah lengkap dan tidak dapat diubah</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-orange-500 mt-1">•</span>
                        <span>Lamaran tidak dapat dibatalkan setelah dikirim</span>
                    </li>
                </ul>
            </div>

            <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                <p class="font-medium text-blue-800">
                    Apakah Anda yakin mendaftar sebagai <strong>{{ $intern->title }}</strong>?
                </p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-between gap-4 mt-8">
            <a href="{{ route('participant.internships.show', $intern->id) }}"
               class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all flex-1 text-center">
                Kembali
            </a>
            <form action="{{ route('participant.internships.apply', $intern->id) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-br from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition-all font-medium">
                    Ya, Daftar Sekarang
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
