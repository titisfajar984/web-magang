<section class="relative min-h-screen lg:h-screen bg-[#F8F8FD] pt-24 px-4 sm:px-12 md:px-20 lg:px-24 overflow-hidden flex">
    <img
        src="{{ asset('assets/bg/magang-background.svg') }}"
        alt="Background dekorasi magang"
        class="pointer-events-none select-none absolute bottom-0 -right-1/10  sm:right-0 h-1/2 sm:h-3/4 lg:h-full z-0"
    />

    <div class="flex flex-col lg:flex-row gap-12 z-1">
        <div class="flex flex-col justify-center gap-y-6 pb-8 flex-1">
            <div class="w-fit flex flex-col gap-y-4">
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-[#25324B]">
                    Ayo Magang Bersama Kami
                </h2>
                <img
                    src="{{ asset('assets/decor/underline-highlight.png') }}"
                    alt=""
                    role="presentation"
                    class="w-8/10"
                    loading="lazy"
                />
            </div>
            <p class="text-base sm:text-lg md:text-[18px] lg:text-xl text-[#5F6D7E]">
                Temukan tempat magang terbaik dan mitra perusahaan terpercaya di seluruh Indonesia. Ajukan magang dan kelola tugas dengan mudah.
            </p>
            <a href="{{ route('login') }}" class="mx-auto md:mx-0 w-fit text-sm sm:text-[15px] md:text-base lg:text-[17px] font-semibold text-white py-2 px-6 bg-[#4640DE] rounded-sm transition duration-300 hover:bg-[#3730a3] focus:outline-none focus-visible:ring focus-visible:ring-[#4640DE]/50">
                Cari Lowongan
            </a>
        </div>
        <div class="hidden lg:flex flex-1">
            <img src="{{ asset('assets/img/magang-illustrasi-tempat-magang-terpercaya.png') }}" alt="Ilustrasi Magang di Tempat Magang Terpercaya" class="w-full max-w-md mx-auto mt-auto" />
        </div>
    </div>

    <div class="hidden lg:flex absolute bottom-0 right-0 w-0 h-0 border-l-[260px] border-l-transparent border-b-[160px] border-b-white z-1"></div>
</section>
