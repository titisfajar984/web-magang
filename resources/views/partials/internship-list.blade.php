<section class="relative py-4 px-4 sm:px-12 md:px-20 lg:px-24 overflow-hidden flex flex-col gap-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-4xl md:text-5xl font-bold text-[#25324B]">
            Lowongan <span class="text-[#26A4FF]">Magang</span>
        </h2>
        <a href="{{ route('login') }}" class="text-base text-[#4640DE] gap-x-4 font-bold hover:border-b-1 hidden md:flex">
            Selengkapnya
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </a>
    </div>

    <div class="flex gap-4 md:gap-8 overflow-x-auto snap-x snap-mandatory sm:grid sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($internships as $item)
            <div class="min-w-[280px] max-w-[320px] shrink-0 snap-start sm:min-w-0 sm:max-w-none sm:w-auto bg-white rounded-sm p-6 border border-[#D6DDEB] flex flex-col gap-y-4">
                <div class="flex justify-between">
                    <img src="{{ $item->company->logo ? asset('storage/'.$item->company->logo) : asset('assets/img/logo-magang-berdampak.png')  }}" class="w-12 h-12" alt="Logo Perusahaan">
                    <div class="py-1 px-3 text-[#4640DE] border border-[#4640DE] w-fit h-fit text-xs">
                        <p>{{$item->location}}</p>
                    </div>
                </div>
                <div class="flex flex-col gap-y-1">
                    <h3 class="text-lg text-[#25324B] font-bold">
                        {{ $item->title }}
                    </h3>
                    <div class="flex gap-x-2 items-center text-[#515B6F] text-sm">
                        <p>Kuota {{ $item->quota }}</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="4" height="4" viewBox="0 0 4 4" fill="none">
                            <circle opacity="0.3" cx="2" cy="2" r="2" fill="#515B6F"/>
                        </svg>
                        <p>{{ $item->company->name }}</p>
                    </div>
                </div>
                <p class="text-base text-[#7C8493] line-clamp-2">
                    {{ Str::limit(strip_tags($item->description), 100) }}
                </p>
                <div class="flex gap-x-2 text-sm">
                    <div class="px-3 py-1 font-bold rounded-[80px] bg-[#EB85331A]">
                        <p class="text-[#FFB836]">
                            {{ $item->start_date->diffInMonths($item->end_date) }} Bulan
                        </p>
                    </div>
                    <div class="px-3 py-1 font-bold rounded-[80px] bg-[#56CDAD1A]">
                        <p class="text-[#56CDAD]">
                            {{ $item->start_date->format('d M Y') }} - {{ $item->end_date->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <a href="{{ route('login') }}" class="text-base text-[#4640DE] flex gap-x-4 font-bold hover:border-b-1 md:hidden">
        Selengkapnya
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0-7.5 7.5M21 12H3" />
        </svg>
    </a>
</section>
