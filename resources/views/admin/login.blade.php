<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Dialogen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: {
            brand: { red: '#DC2626', navy: '#201658', indigo: '#312E81' }
        } } } }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }</style>
</head>
<body class="min-h-screen bg-[#0F0B26] flex items-center justify-center px-5">

    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-brand-red to-brand-indigo flex items-center justify-center mx-auto shadow-lg shadow-brand-red/20">
                <span class="text-white font-extrabold text-xl">D</span>
            </div>
            <h1 class="mt-4 text-xl font-extrabold text-white">Dialogen Admin</h1>
            <p class="text-sm text-gray-400 mt-1">Masuk untuk mengelola feedback pengguna</p>
        </div>

        <div class="bg-[#161233] border border-white/5 rounded-2xl p-6 shadow-xl">
            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wide">Password Admin</label>
                    <input type="password" name="password" autofocus
                           class="w-full px-4 py-3 rounded-xl bg-[#0F0B26] border border-white/10 text-white placeholder-gray-500 focus:border-brand-red focus:ring-2 focus:ring-brand-red/20 outline-none transition-all text-sm">
                    @error('password')
                        <p class="text-xs text-brand-red mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-3 rounded-xl bg-gradient-to-r from-brand-red to-brand-indigo text-white font-bold text-sm hover:opacity-90 transition-opacity">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-500 mt-6">Halaman ini khusus untuk tim internal Dialogen.</p>
    </div>
</body>
</html>
