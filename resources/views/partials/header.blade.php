<header id="main-header"
  class="fixed top-0 left-0 w-full z-50 transition-all duration-300 ease-in-out">
  <nav
    class="relative flex items-center justify-between py-4 px-4 sm:px-12 md:px-20 lg:px-24"
    aria-label="Navigasi utama">

    <a href="{{ url('/') }}" class="flex items-center gap-x-2">
      <img src="{{ asset('assets/img/logo-magang-berdampak.png') }}" alt="Logo Magang Berdampak"
        class="h-10 w-auto transition-transform duration-300 hover:scale-105" />
      <h1 class="text-lg sm:text-xl md:text-[20px] lg:text-2xl font-bold text-[#25324B]">Magang Berdampak</h1>
    </a>

    <button id="menu-toggle" class="sm:hidden focus:outline-none bg-white rounded-full border-1 border-[#D6DDEB] p-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
      </svg>
    </button>

    <div id="mobile-menu"
      class="absolute top-full left-0 -translate-x-full sm:translate-x-0 sm:static flex flex-col sm:flex-row items-center sm:gap-x-4 gap-y-3 sm:gap-y-0 w-full sm:w-auto transition-all duration-300 z-40 sm:z-auto bg-[#EBEBEB8A] sm:bg-transparent shadow-md sm:shadow-none rounded-b-xl sm:rounded-none px-6 py-4 sm:p-0">

      <a href="{{ route('login') }}"
        class="text-sm sm:text-[15px] md:text-base lg:text-[17px] font-semibold text-[#4640DE] border-b sm:border-none w-full sm:w-fit text-center py-2 px-6 sm:rounded-sm transition duration-300 hover:bg-[#ecebfc] focus:outline-none focus-visible:ring focus-visible:ring-[#4640DE]/50">
        Masuk
      </a>

      <div class="h-8 sm:block hidden border-l border-[#D6DDEB]"></div>

      <a href="{{ route('register') }}"
        class="text-sm sm:text-[15px] md:text-base lg:text-[17px] font-semibold text-[#4640DE] border-b w-full sm:w-fit text-center sm:text-white py-2 px-6 sm:bg-[#4640DE] sm:rounded-sm transition duration-300 hover:bg-[#3730a3] focus:outline-none focus-visible:ring focus-visible:ring-[#4640DE]/50">
        Daftar
      </a>
    </div>
  </nav>
</header>
