<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - {{ config('app.name', 'Magang Berdampak') }}</title>

  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://unpkg.com/flowbite@1.7.0/dist/flowbite.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100">
  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg">
      <div class="p-6 flex items-center space-x-3">
        <img src="{{ asset('assets/img/Logo 2.png') }}" alt="Logo" class="h-12 w-12">
        <h1 class="text-xl font-semibold text-gray-800">Magang Berdampak</h1>
      </div>

      <ul class="space-y-2 px-4">
        @php
          $menus = [
            ['route' => 'admin.index',   'icon' => 'home',      'label' => 'Dashboard'],
            ['route' => 'admin.users.index',   'icon' => 'users',     'label' => 'User'],
            ['route' => 'admin.company.index','icon' => 'briefcase','label' => 'Company'],
          ];
        @endphp

        @foreach($menus as $item)
          <li>
            <a href="{{ route($item['route']) }}"
               class="flex items-center p-3 rounded-lg hover:bg-blue-50 {{ request()->routeIs(str_replace('admin.', '', $item['route']).'*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600' }}">
              <i data-feather="{{ $item['icon'] }}" class="w-5 h-5 mr-3"></i>
              {{ $item['label'] }}
            </a>
          </li>
        @endforeach

        <li class="pt-4 border-t border-gray-200 mt-4">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center p-3 rounded-lg hover:bg-red-50 text-gray-600 hover:text-red-600 transition">
              <i data-feather="log-out" class="w-5 h-5 mr-3"></i>
              Logout
            </button>
          </form>
        </li>
      </ul>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Navbar -->
      <nav class="bg-white shadow flex items-center justify-between px-6 py-4">
        <h2 class="text-2xl font-semibold text-gray-800">@yield('title')</h2>
        <div class="flex items-center space-x-4">
          <button class="relative p-2 hover:bg-gray-100 rounded-full">
            <i data-feather="bell" class="w-6 h-6 text-gray-600"></i>
            <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-500 rounded-full"></span>
          </button>
          <div class="flex items-center space-x-2">
            <div class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center uppercase text-sm">
              {{ substr(auth()->user()->name, 0, 1) }}
            </div>
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

  <!-- Scripts -->
  <script src="https://unpkg.com/flowbite@1.7.0/dist/flowbite.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script>
    feather.replace();
  </script>
</body>
</html>
