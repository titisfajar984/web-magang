<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Bangun Pengalaman, Raih Kesuksesan - Magang Berdampak')</title>
    <meta name="description" content="@yield('meta_description', 'Temukan tempat magang terbaik dan mitra perusahaan terpercaya di seluruh Indonesia. Ajukan magang dan kelola tugas dengan mudah.')">
    <meta name="keywords" content="@yield('meta_keywords', 'magang, tempat magang, mitra perusahaan, internship, cari magang, tugas magang')">
    <meta name="author" content="Magang Berdampak by PT Imersa Solusi Teknologi">
    <meta name="robots" content="index, follow">

    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:title" content="@yield('title', 'Bangun Pengalaman, Raih Kesuksesan - Magang Berdampak')">
    <meta property="og:description" content="@yield('meta_description', 'Temukan tempat magang terbaik dan mitra perusahaan terpercaya.')">
    <meta property="og:image" content="@yield('meta_image', asset('img/og-magang-berdampak.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Bangun Pengalaman, Raih Kesuksesan - Magang Berdampak')">
    <meta name="twitter:description" content="@yield('meta_description')">
    <meta name="twitter:image" content="@yield('meta_image', asset('img/og-magang-berdampak.png'))">

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/logo-magang-berdampak.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-magang-berdampak.png') }}">

    <style>
    #main-header {
        background-color: transparent;
    }

    @media (max-width: 639px) {
        #main-header {
        background-color: rgba(235, 235, 235, 0.6);
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
        box-shadow: none !important;
        }
    }

    #main-header.sticky {
        background-color: rgba(255, 255, 255, 0.65);
        backdrop-filter: saturate(180%) blur(12px);
        -webkit-backdrop-filter: saturate(180%) blur(12px);
    }
    </style>

    @vite('resources/css/app.css')

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "Organization",
                "name": "Magang Berdampak",
                "url": "{{ url('/') }}",
                "logo": "{{ asset('images/logo.png') }}"
            },
            {
                "@type": "WebSite",
                "name": "Magang Berdampak",
                "url": "{{ url('/') }}",
                "potentialAction": {
                    "@type": "SearchAction",
                    "target": "{{ url('/search?q={search_term_string}') }}",
                    "query-input": "required name=search_term_string"
                }
            },
            {
                "@type": "WebPage",
                "name": "Bangun Pengalaman, Raih Kesuksesan - Magang Berdampak",
                "url": "{{ url()->current() }}",
                "description": "Temukan tempat magang terbaik dan mitra perusahaan terpercaya di seluruh Indonesia. Ajukan magang dan kelola tugas dengan mudah.",
                "inLanguage": "id",
                "isPartOf": {
                    "@type": "WebSite",
                    "url": "{{ url('/') }}"
                }
            }
        ]
    }
    </script>

    @stack('head')
</head>
<body class="bg-white antialiased">
    
    @include('partials.header')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('partials.footer')
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.getElementById('menu-toggle');
        const navMenu = document.getElementById('mobile-menu');
        const menuHiddenClass = '-translate-x-full';
        const header = document.getElementById('main-header');

        toggleButton.addEventListener('click', function (e) {
        e.stopPropagation();
        navMenu.classList.toggle(menuHiddenClass);
        });

        document.addEventListener('click', function (e) {
        if (!toggleButton.contains(e.target) && !navMenu.contains(e.target)) {
            if (!navMenu.classList.contains(menuHiddenClass)) {
            navMenu.classList.add(menuHiddenClass);
            }
        }
        });

        function onScroll() {
        if (window.innerWidth >= 640) {
            if (window.scrollY > 10) {
            header.classList.add('sticky');
            } else {
            header.classList.remove('sticky');
            }
        } else {
            header.classList.remove('sticky');
        }
        }

        window.addEventListener('scroll', onScroll);
        window.addEventListener('resize', onScroll);
        onScroll();
    });
    </script>
    
    @stack('scripts')
</body>
</html>
