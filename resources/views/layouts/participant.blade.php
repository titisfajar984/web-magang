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
  <div class="flex h-screen" x-data="{ openKegiatan: false }">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg">
      <div class="p-6 flex items-center space-x-3">
        <img src="{{ asset('assets/img/Logo 2.png') }}" alt="Logo" class="h-12 w-12">
        <h1 class="text-xl font-semibold text-gray-800">Magang Berdampak</h1>
      </div>

      <ul class="space-y-2 px-4">
        @php
            $menus = [
              ['route' => 'participant.index', 'icon' => 'home', 'label' => 'Dashboard'],
              ['route' => 'participant.internships.index', 'icon' => 'briefcase', 'label' => 'Lowongan'],
              ['route' => 'participant.apply.index', 'icon' => 'file-text', 'label' => 'Riwayat'],
              ['route' => 'participant.profile.index', 'icon' => 'user', 'label' => 'Profil'],
            ];
        @endphp

        @foreach($menus as $item)
          <li>
            <a href="{{ route($item['route']) }}"
              class="flex items-center p-3 rounded-lg hover:bg-blue-50
              {{ request()->routeIs($item['route']) ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600' }}">
              <i data-feather="{{ $item['icon'] }}" class="w-5 h-5 mr-3"></i>
              {{ $item['label'] }}
            </a>
          </li>

          @if($item['label'] === 'Riwayat')
            <!-- Menu Kegiatan -->
            <li class="relative">
              <button type="button" @click="openKegiatan = !openKegiatan"
                class="w-full flex items-center justify-between p-3 rounded-lg text-gray-600 hover:bg-blue-50 transition">
                <span class="flex items-center">
                  <i data-feather="activity" class="w-5 h-5 mr-3"></i> Kegiatan
                </span>
                <svg :class="{ 'rotate-180': openKegiatan }" class="w-4 h-4 transform transition-transform" fill="none"
                  stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              <ul x-show="openKegiatan" x-transition class="ml-8 mt-1 space-y-1" style="display: none;">
                <li>
                  <a href="{{ route('participant.tasks.index') }}"
                    class="flex items-center p-2 rounded-lg text-sm hover:bg-blue-50
                    {{ request()->routeIs('participant.tasks.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600' }}">
                    <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Tugas
                  </a>
                </li>
                <li>
                  <a href="{{ route('participant.logbooks.index') }}"
                    class="flex items-center p-2 rounded-lg text-sm hover:bg-blue-50
                    {{ request()->routeIs('participant.logbooks.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600' }}">
                    <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Logbook
                  </a>
                </li>
                <li>
                  <a href="{{ route('participant.finalreports.index') }}"
                    class="flex items-center p-2 rounded-lg text-sm hover:bg-blue-50
                    {{ request()->routeIs('participant.finalreports.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600' }}">
                    <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Laporan Akhir
                  </a>
                </li>
                <li>
                    <a href="{{ route('participant.certificates.show', auth()->user()->participantProfile->id) }}"
                        class="flex items-center p-2 rounded-lg text-sm hover:bg-blue-50
                        {{ request()->routeIs('participant.certificates.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600' }}">
                        <i data-feather="award" class="w-4 h-4 mr-2"></i> Sertifikat
                    </a>
                </li>
              </ul>
            </li>
          @endif
        @endforeach

        <li class="pt-4 border-t border-gray-200 mt-4">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
              class="w-full flex items-center p-3 rounded-lg hover:bg-red-50 text-gray-600 hover:text-red-600 transition">
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
        <h2 class="text-2xl font-semibold text-gray-800">@yield('title')</h2>
        <div class="flex items-center space-x-4">
          @php
            use App\Models\ParticipantProfile;
            $profile = ParticipantProfile::where('user_id', auth()->id())->first();
            $userName = auth()->user() ? auth()->user()->name : '';
          @endphp
          <div class="flex items-center space-x-2">
            @if($profile && $profile->photo)
              <img src="{{ asset('storage/' . $profile->photo) }}" alt="Foto Profil" class="w-8 h-8 rounded-full object-cover border border-gray-300">
            @else
              <div class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center uppercase">
                {{ strtoupper(substr($userName, 0, 1)) }}
              </div>
            @endif
          </div>
        </div>
      </nav>

      <!-- Page Content -->
      <main class="flex-1 overflow-auto p-6">
        @yield('content')
      </main>
    </div>
  </div>

  <!-- JS -->
  <script src="https://unpkg.com/flowbite@1.7.0/dist/flowbite.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      feather.replace()
    })
  </script>
</body>
</html>
