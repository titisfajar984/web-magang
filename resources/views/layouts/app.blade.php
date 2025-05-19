<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title') - {{ config('app.name', 'Magang Berdampak') }}</title>

  {{-- TailwindCSS & Flowbite --}}
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://unpkg.com/flowbite@1.7.0/dist/flowbite.min.css" rel="stylesheet">
  {{-- Professional Font: Poppins --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>
<body class="bg-gray-100">
  <div class="flex h-screen">
    {{-- Sidebar --}}
    <aside class="w-64 bg-white shadow-lg flex-shrink-0">
      <div class="p-6 flex items-center space-x-3">
        <img src="{{ asset('assets/img/Logo 2.png') }}" alt="Logo" class="h-12 w-12">
        <span class="text-xl font-semibold text-gray-800">{{ config('app.name', 'Magang Berdampak') }}</span>
      </div>
      <nav class="px-4 space-y-2">
        @php
          $menus = match(auth()->user()->role) {
            'admin' => [
              ['route' => 'admin.index', 'icon' => 'home', 'label' => 'Dashboard'],
              ['route' => 'admin.users.index', 'icon' => 'users', 'label' => 'Users'],
              ['route' => 'admin.company.index', 'icon' => 'briefcase', 'label' => 'Companies'],
            ],
            'company' => [
              ['route' => 'company.index', 'icon' => 'home', 'label' => 'Dashboard'],
              ['route' => 'company.internships.index', 'icon' => 'briefcase', 'label' => 'Lowongan'],
              ['route' => 'company.apply.index', 'icon' => 'file-text', 'label' => 'Lamaran'],
              ['route' => 'company.profile.index', 'icon' => 'user', 'label' => 'Profil'],
            ],
            'participant' => [
              ['route' => 'participant.index', 'icon' => 'home', 'label' => 'Dashboard'],
              ['route' => 'participant.internships.index', 'icon' => 'briefcase', 'label' => 'Lowongan'],
              ['route' => 'participant.apply.index', 'icon' => 'file-text', 'label' => 'Riwayat'],
              ['route' => 'participant.profile.index', 'icon' => 'user', 'label' => 'Profil'],
            ],
            default => [],
          };
        @endphp
        @foreach($menus as $item)
          <a href="{{ route($item['route']) }}"
             class="flex items-center p-3 rounded-lg hover:bg-blue-50 transition
             {{ request()->routeIs($item['route'].'*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600' }}">
            <i data-feather="{{ $item['icon'] }}" class="w-5 h-5 mr-3"></i>
            <span>{{ $item['label'] }}</span>
          </a>
        @endforeach

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST" class="mt-6 px-4">
          @csrf
          <button type="submit"
                  class="flex items-center p-3 rounded-lg hover:bg-red-50 text-gray-600 hover:text-red-600 transition">
            <i data-feather="log-out" class="w-5 h-5 mr-3"></i>Logout
          </button>
        </form>
      </nav>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-hidden">
      {{-- Navbar --}}
      <header class="bg-white shadow flex items-center justify-between px-6 py-4">
        <h1 class="text-2xl font-semibold text-gray-800">@yield('title')</h1>
        <div class="flex items-center space-x-4">
          <button class="relative p-2 hover:bg-gray-100 rounded-full transition">
            <i data-feather="bell" class="w-6 h-6 text-gray-600"></i>
            <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-500 rounded-full"></span>
          </button>
          <div class="flex items-center space-x-2">
            @if(auth()->user()->role === 'company' && auth()->user()->companyProfile?->logo)
              <img src="{{ asset('storage/' . auth()->user()->companyProfile->logo) }}" alt="Logo" class="w-8 h-8 rounded-full object-cover">
            @elseif(auth()->user()->role === 'participant' && auth()->user()->participantProfile?->photo)
              <img src="{{ asset('storage/' . auth()->user()->participantProfile->photo) }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
            @else
              <div class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center uppercase">
                {{ substr(auth()->user()->name, 0, 1) }}
              </div>
            @endif
          </div>
        </div>
      </header>

      {{-- Page Content --}}
      <main class="flex-1 overflow-auto p-6">
        @if(session('success'))
          <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">{{ session('error') }}</div>
        @endif

        @yield('content')
      </main>
    </div>
  </div>

  {{-- Scripts --}}
  <script src="https://unpkg.com/flowbite@1.7.0/dist/flowbite.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script>feather.replace()</script>
</body>
</html>
