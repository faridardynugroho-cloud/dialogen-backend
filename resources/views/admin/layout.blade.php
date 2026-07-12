<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Dialogen Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { red: '#DC2626', navy: '#201658', indigo: '#312E81' },
                        panel: '#161233',
                        panel2: '#1D1840',
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
        ::-webkit-scrollbar { height: 8px; width: 8px; }
        ::-webkit-scrollbar-thumb { background: #4C4A7A; border-radius: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
    </style>
</head>
<body class="bg-[#0F0B26] text-gray-200 antialiased min-h-screen">

    <div class="flex min-h-screen">
        {{-- SIDEBAR --}}
        <aside class="w-64 bg-panel border-r border-white/5 flex-shrink-0 hidden lg:flex lg:flex-col">
            <div class="h-16 flex items-center gap-2.5 px-6 border-b border-white/5">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-red to-brand-indigo flex items-center justify-center">
                    <span class="text-white font-extrabold text-xs">D</span>
                </div>
                <span class="font-extrabold text-white">Dialogen<span class="text-brand-red">.</span>Admin</span>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-1">
                <a href="{{ route('admin.feedback.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.feedback.*') ? 'bg-brand-red/15 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-6l-4 4v-4z" />
                    </svg>
                    Feedback & Bug Report
                </a>
            </nav>

            <div class="p-3 border-t border-white/5">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:bg-white/5 hover:text-brand-red transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-16 border-b border-white/5 flex items-center justify-between px-5 lg:px-8 bg-panel/60 backdrop-blur">
                <h1 class="text-lg font-bold text-white">@yield('page_title', 'Dashboard')</h1>
                <div class="flex items-center gap-2 text-xs text-gray-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Admin Session Aktif
                </div>
            </header>

            <main class="flex-1 p-5 lg:p-8">
                @if (session('success'))
                    <div class="mb-6 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-xl px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
