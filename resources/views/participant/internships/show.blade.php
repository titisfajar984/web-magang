@extends('layouts.participant')

@section('title', 'Detail Intern')

@section('content')
<div class="bg-white min-h-screen">
    <div class="container mx-auto px-4 py-12 max-w-3xl">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('participant.internships.index') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Intern
            </a>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            <!-- Company Header -->
            <div class="p-8 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center gap-6">
                    <img src="{{ $intern->company && $intern->company->logo ? asset('storage/' . $intern->company->logo) : asset('default-company.png') }}"
                         class="w-20 h-20 rounded-lg border-2 border-white shadow-sm object-cover">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $intern->company->name }}</h1>
                        <p class="text-gray-600 mt-1">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $intern->company->address }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Job Details -->
            <div class="p-8">
                <!-- Title Section -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $intern->title }}</h2>
                    <div class="flex items-center gap-4 text-gray-600">
                        <span class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            {{ \Carbon\Carbon::parse($intern->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($intern->end_date)->format('d M Y') }}
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-users mr-2"></i>
                            Kuota: {{ $intern->quota }}
                        </span>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="mb-8">
                    <span class="px-4 py-2 rounded-full text-sm font-medium
                              {{ $intern->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($intern->status) }}
                    </span>
                </div>

                <!-- Description -->
                <div class="prose max-w-none mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Deskripsi Magang</h3>
                    {!! nl2br(e($intern->description)) !!}
                </div>

                <!-- Company Info -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Tentang Perusahaan</h3>
                    <div class="prose max-w-none">
                        {{ $intern->company->description ?? 'Tidak ada deskripsi perusahaan' }}
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="mt-8">
                    @if(auth()->user()->participantProfile)
                        @if($alreadyApplied)
                            <button class="w-full py-4 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed" disabled>
                                Sudah terdaftar
                            </button>
                        @else
                            <a href="{{ route('participant.internships.confirmation', $intern->id) }}"
                            class="block w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-center transition-all">
                                Daftar Sekarang
                            </a>
                        @endif
                    @else
                        <a href="{{ route('participant.profile.edit') }}"
                           class="block w-full py-4 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold text-center transition-all">
                            Lengkapi Profil Terlebih Dahulu
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmRegistration() {
    return confirm(
        "Dengan mendaftar pada program magang ini, saya menyatakan bahwa seluruh data yang saya isi adalah benar, dan saya bersedia untuk mengikuti seluruh proses seleksi serta peraturan yang berlaku di perusahaan terkait.\n\nSaya juga memahami bahwa pendaftaran ini bersifat final dan tidak dapat dibatalkan tanpa alasan yang jelas.\n\nApakah Anda yakin ingin melanjutkan pendaftaran?"
    );
}
</script>
@endsection
