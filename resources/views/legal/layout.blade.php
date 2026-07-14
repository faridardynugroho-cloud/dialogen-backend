<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dialogen') — Dialogen</title>
    <meta name="description" content="@yield('meta_description', 'Dialogen — Platform kuis multiplayer untuk belajar dan melestarikan bahasa daerah Indonesia.')">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            red: '#DC2626',
                            navy: '#201658',
                            indigo: '#312E81',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
        .prose-legal h2 { scroll-margin-top: 6rem; }
        .prose-legal a { color: #DC2626; text-decoration: underline; text-underline-offset: 2px; }
        .prose-legal a:hover { color: #201658; }
        ::selection { background-color: #FEE2E2; color: #201658; }
    </style>
    @stack('head')
</head>
<body class="bg-white text-gray-800 antialiased">

    {{-- ===== HEADER ===== --}}
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-5 sm:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('legal.about') }}" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-red to-brand-navy flex items-center justify-center shadow-sm shadow-brand-red/20 group-hover:scale-105 transition-transform">
                    <span class="text-white font-extrabold text-sm">D</span>
                </div>
                <span class="font-extrabold text-brand-navy text-lg tracking-tight">Dialogen</span>
            </a>

            <nav class="hidden sm:flex items-center gap-1 text-sm font-medium">
                <a href="{{ route('legal.about') }}"
                   class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('legal.about') ? 'text-brand-navy bg-gray-100' : 'text-gray-500 hover:text-brand-navy hover:bg-gray-50' }}">
                    Tentang
                </a>
                <a href="{{ route('legal.privacy') }}"
                   class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('legal.privacy') ? 'text-brand-navy bg-gray-100' : 'text-gray-500 hover:text-brand-navy hover:bg-gray-50' }}">
                    Kebijakan Privasi
                </a>
                <a href="{{ route('legal.terms') }}"
                   class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('legal.terms') ? 'text-brand-navy bg-gray-100' : 'text-gray-500 hover:text-brand-navy hover:bg-gray-50' }}">
                    Syarat & Ketentuan
                </a>
                <a href="{{ route('legal.feedback') }}"
                   class="ml-2 px-4 py-2 rounded-lg bg-brand-navy text-white hover:bg-brand-red transition-colors">
                    Kirim Masukan
                </a>
            </nav>

            {{-- Mobile menu button --}}
            <button id="mobileMenuBtn" class="sm:hidden w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-100" aria-label="Buka menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-brand-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- Mobile nav --}}
        <div id="mobileMenu" class="hidden sm:hidden border-t border-gray-100 bg-white">
            <div class="px-5 py-3 flex flex-col gap-1 text-sm font-medium">
                <a href="{{ route('legal.about') }}" class="px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50">Tentang Dialogen</a>
                <a href="{{ route('legal.privacy') }}" class="px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50">Kebijakan Privasi</a>
                <a href="{{ route('legal.terms') }}" class="px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50">Syarat & Ketentuan</a>
                <a href="{{ route('legal.feedback') }}" class="px-3 py-2.5 rounded-lg bg-brand-navy text-white text-center mt-1">Kirim Masukan</a>
            </div>
        </div>
    </header>

    <script>
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function () {
            document.getElementById('mobileMenu')?.classList.toggle('hidden');
        });
    </script>

    {{-- ===== MAIN CONTENT ===== --}}
    <main>
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="border-t border-gray-100 bg-gray-50/60 mt-20">
        <div class="max-w-5xl mx-auto px-5 sm:px-8 py-12">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-8">
                <div class="max-w-xs">
                    <div class="flex items-center gap-2.5 mb-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-red to-brand-navy flex items-center justify-center">
                            <span class="text-white font-extrabold text-xs">D</span>
                        </div>
                        <span class="font-extrabold text-brand-navy">Dialogen</span>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Bermain, belajar, dan menjelajahi kekayaan bahasa daerah Indonesia lewat kuis multiplayer yang seru.
                    </p>
                </div>

                <div class="grid grid-cols-2 sm:flex sm:gap-14 gap-8 text-sm">
                    <div>
                        <p class="font-semibold text-brand-navy mb-3">Informasi</p>
                        <ul class="space-y-2 text-gray-500">
                            <li><a href="{{ route('legal.about') }}" class="hover:text-brand-red transition-colors">Tentang Dialogen</a></li>
                            <li><a href="{{ route('legal.feedback') }}" class="hover:text-brand-red transition-colors">Laporkan Bug</a></li>
                        </ul>
                    </div>
                    <div>
                        <p class="font-semibold text-brand-navy mb-3">Legal</p>
                        <ul class="space-y-2 text-gray-500">
                            <li><a href="{{ route('legal.privacy') }}" class="hover:text-brand-red transition-colors">Kebijakan Privasi</a></li>
                            <li><a href="{{ route('legal.terms') }}" class="hover:text-brand-red transition-colors">Syarat & Ketentuan</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-400">
                <p>&copy; {{ date('Y') }} Dialogen. Seluruh hak cipta dilindungi.</p>
                <p>Dibuat dengan ❤ untuk pelestarian bahasa daerah Indonesia.</p>
            </div>
        </div>
    </footer>
</body>
</html>
