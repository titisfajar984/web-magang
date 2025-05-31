<section class="relative py-4 px-4 sm:px-12 md:px-20 lg:px-24 overflow-hidden flex flex-col gap-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-4xl md:text-5xl font-bold text-[#25324B]">
            Lowongan <span class="text-[#26A4FF]">Magang</span>
        </h2>
        <a href="/lowongan" class="text-base text-[#4640DE] gap-x-4 font-bold hover:border-b-1 hidden md:flex">
            Selengkapnya
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </a>
    </div>
    <div class="flex gap-4 md:gap-8 overflow-x-auto snap-x snap-mandatory sm:grid sm:grid-cols-2 lg:grid-cols-3">
        @foreach ([1, 2, 3, 4, 5, 6] as $item)
            <div class="min-w-[280px] max-w-[320px] shrink-0 snap-start sm:min-w-0 sm:max-w-none sm:w-auto bg-white rounded-sm p-6 border border-[#D6DDEB] flex flex-col gap-y-4">
                <div class="flex justify-between">
                    <img src="{{ asset('assets/img/logo-magang-berdampak.png') }}" class="w-12 h-12" />
                    <div class="py-1 px-3 text-[#4640DE] border border-[#4640DE] w-fit h-fit">
                        <p>Full Time</p>
                    </div>
                </div>
                <div class="flex flex-col gap-y-1">
                    <h3 class="text-lg text-[#25324B] font-bold">Front-end Developer</h3>
                    <div class="flex gap-x-2 items-center text-[#515B6F]">
                        <p>Kuota 40</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="4" height="4" viewBox="0 0 4 4" fill="none">
                            <circle opacity="0.3" cx="2" cy="2" r="2" fill="#515B6F"/>
                        </svg>
                        <p>Kab. Nganjuk</p>
                    </div>
                </div>
                <p class="text-base text-[#7C8493]">
                    Revolut is looking for Email Marketing to help team ma ...
                </p>
                <div class="flex gap-x-2">
                    <div class="px-3 py-1 font-bold rounded-[80px] bg-[#EB85331A]">
                        <p class="text-[#FFB836]">4 Bulan</p>
                    </div>
                    <div class="px-3 py-1 font-bold rounded-[80px] bg-[#56CDAD1A]">
                        <p class="text-[#56CDAD]">Teknologi</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <a href="/lowongan" class="text-base text-[#4640DE] flex gap-x-4 font-bold hover:border-b-1 flex md:hidden">
        Selengkapnya
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
        </svg>
    </a>
</section>
