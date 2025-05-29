@extends('layouts.participant')

@section('title', 'Sertifikat Peserta')

@section('content')
<div class="container mx-auto max-w-full px-4">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">
        Sertifikat Peserta <span class="text-blue-600">{{ $participant->user->name }}</span>
    </h1>

    @if($participant->applications->isEmpty())
        <div class="text-center py-12 bg-white shadow rounded-lg">
            <p class="text-gray-500 text-lg">Belum ada aplikasi magang yang ditemukan.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($participant->applications as $application)
                @php $certificate = $application->certificate; @endphp

                <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center transition hover:shadow-xl">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-4">
                        <i data-feather="award" class="w-7 h-7"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-center text-gray-700 mb-2">
                        {{ $application->internship->title }}
                    </h2>

                    @if($certificate)
                        <p class="text-sm text-center text-gray-500 mb-3">
                            Diterbitkan pada: <br>
                            <span class="font-medium">{{ optional($certificate->created_at)->format('d M Y') }}</span>
                        </p>
                        <a href="{{ Storage::url($certificate->file_path) }}" target="_blank"
                            class="mt-auto px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition-all duration-300">
                            Unduh Sertifikat
                        </a>
                    @else
                        <p class="text-sm text-gray-400 italic mt-4">Sertifikat belum tersedia.</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
