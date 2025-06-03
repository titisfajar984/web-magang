<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title') - {{ config('app.name', 'Magang Berdampak') }}</title>

  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://unpkg.com/flowbite@1.7.0/dist/flowbite.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-100">
  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside id="menu-navigation" class="h-full bg-white shadow-lg transition-all duration-300" data-open="true">
      <div class="p-6 flex gap-x-4 items-center justify-between">
        <div class="flex gap-x-2 items-center">
          <img src="{{ asset('assets/img/Logo 2.png') }}" alt="Logo">
          <h1 class="text-lg sm:text-xl font-semibold text-gray-800">Magang Berdampak</h1>
        </div>
        <button id="menu-close" class="sm:hidden focus:outline-none bg-white">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <ul class="space-y-2 px-4">
        @php
          $menus = [
            ['route' => 'company.index',              'icon' => 'home',      'label' => 'Dashboard'],
            ['route' => 'company.internships.index',  'icon' => 'briefcase', 'label' => 'Lowongan'],
            ['route' => 'company.apply.index',        'icon' => 'file-text', 'label' => 'Lamaran'],
            ['route' => 'company.participants.index',      'icon' => 'users',      'label' => 'Peserta'],
            ['route' => 'company.profile.index',      'icon' => 'user',      'label' => 'Profil'],
          ];
        @endphp

        @foreach($menus as $item)
          <li>
            <a href="{{ route($item['route']) }}"
               class="flex items-center p-3 rounded-lg hover:bg-blue-50 {{ request()->routeIs($item['route']) ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600' }}">
              <i data-feather="{{ $item['icon'] }}" class="w-5 h-5 mr-3"></i>
              {{ $item['label'] }}
            </a>
          </li>
        @endforeach

        <li class="pt-4 border-t border-gray-200 mt-4">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center p-3 rounded-lg hover:bg-red-50 text-gray-600 hover:text-red-600 transition">
              <i data-feather="log-out" class="w-5 h-5 mr-3"></i> Logout
            </button>
          </form>
        </li>
      </ul>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Navbar -->
      <nav class="bg-white shadow flex items-center justify-between px-6 py-4">
        <div class="flex gap-x-2 items-center">
          <button id="menu-toggle" class="text-gray-800 focus:outline-none bg-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
            </svg>
          </button>
          <h2 class="text-2xl font-semibold text-gray-800">@yield('title')</h2>
        </div>
        <div class="flex items-center space-x-4">
          <div class="flex items-center space-x-2">
            @php
              $company = \App\Models\CompanyProfile::where('user_id', auth()->id())->first();
            @endphp
            @if ($company && $company->logo)
              <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo Perusahaan" class="w-8 h-8 rounded-full object-cover">
            @else
              <div class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center uppercase text-sm">
                {{ substr(auth()->user()->name, 0, 1) }}
              </div>
            @endif
          </div>
        </div>
      </nav>

      <!-- Page Content -->
      <main class="flex-1 overflow-auto p-6">
        @if(session('success'))
          <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            {{ session('error') }}
          </div>
        @endif

        @yield('content')
      </main>
    </div>
  </div>

  <!-- JS -->
  <script src="https://unpkg.com/flowbite@1.7.0/dist/flowbite.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script>feather.replace()</script>
  <script src="{{ asset('js/navigation.js') }}"></script>
</body>
</html>
