@extends('legal.layout')

@section('title', 'Kirim Masukan')
@section('meta_description', 'Laporkan bug atau kirim masukan untuk membantu kami meningkatkan kualitas aplikasi Dialogen.')

@section('content')

    <section class="bg-gradient-to-b from-brand-red to-white">
        <div class="max-w-2xl mx-auto px-5 sm:px-8 pt-16 pb-14 text-center">
            <span class="inline-block px-4 py-1.5 rounded-full bg-white/15 text-white text-xs font-semibold tracking-wide uppercase backdrop-blur-sm border border-white/20">
                Kami Mendengarkan
            </span>
            <h1 class="mt-6 text-3xl sm:text-4xl font-extrabold text-white">Kirim Masukan atau Laporkan Bug</h1>
            <p class="mt-4 text-white/90 max-w-lg mx-auto leading-relaxed">
                Setiap masukan membantu kami membuat Dialogen lebih baik. Ceritakan apa yang kamu temukan atau ide yang kamu punya.
            </p>
        </div>
    </section>

    <div class="max-w-2xl mx-auto px-5 sm:px-8 -mt-8 pb-24 relative z-10">

        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-5 py-4 flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="font-semibold">Terima kasih!</p>
                    <p class="text-sm mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl shadow-brand-navy/10 border border-gray-100 p-6 sm:p-8">
            <form method="POST" action="{{ route('legal.feedback.submit') }}" class="space-y-6">
                @csrf

                {{-- Hidden fields, auto-filled by app via query string: ?version=1.0.0&build=5&platform=android --}}
                <input type="hidden" name="app_version" value="{{ request('version') }}">
                <input type="hidden" name="app_build" value="{{ request('build') }}">
                <input type="hidden" name="platform" value="{{ request('platform', 'unknown') }}">

                {{-- Type --}}
                <div>
                    <label class="block text-sm font-bold text-brand-navy mb-3">Jenis Masukan</label>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach (['bug' => ['🐞', 'Laporkan Bug'], 'saran' => ['💡', 'Saran Fitur'], 'lainnya' => ['💬', 'Lainnya']] as $value => [$emoji, $label])
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="{{ $value }}" class="peer sr-only"
                                       {{ old('type', 'bug') === $value ? 'checked' : '' }}>
                                <div class="rounded-xl border-2 border-gray-200 peer-checked:border-brand-red peer-checked:bg-red-50 px-3 py-4 text-center transition-colors">
                                    <span class="text-xl block mb-1">{{ $emoji }}</span>
                                    <span class="text-xs font-semibold text-gray-600 peer-checked:text-brand-red">{{ $label }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('type') <p class="text-xs text-brand-red mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- Judul --}}
                <div>
                    <label for="title" class="block text-sm font-bold text-brand-navy mb-2">Judul Singkat</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           placeholder="Contoh: Skor tidak update setelah babak terakhir"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-red focus:ring-2 focus:ring-brand-red/10 outline-none transition-all text-sm">
                    @error('title') <p class="text-xs text-brand-red mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="message" class="block text-sm font-bold text-brand-navy mb-2">Ceritakan Detailnya</label>
                    <textarea name="message" id="message" rows="5"
                              placeholder="Jelaskan apa yang terjadi, langkah untuk mereproduksi bug, atau ide fitur yang kamu maksud..."
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-red focus:ring-2 focus:ring-brand-red/10 outline-none transition-all text-sm resize-none">{{ old('message') }}</textarea>
                    @error('message') <p class="text-xs text-brand-red mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- Email opsional --}}
                <div>
                    <label for="email" class="block text-sm font-bold text-brand-navy mb-2">
                        Email <span class="font-normal text-gray-400">(opsional, kalau ingin ditindaklanjuti)</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           placeholder="nama@email.com"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-brand-red focus:ring-2 focus:ring-brand-red/10 outline-none transition-all text-sm">
                    @error('email') <p class="text-xs text-brand-red mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- Device info preview (kalau dikirim dari app) --}}
                @if (request('version'))
                    <div class="bg-gray-50 rounded-xl px-4 py-3 text-xs text-gray-500 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        </svg>
                        Terkirim otomatis: versi {{ request('version') }} (build {{ request('build') }}), {{ ucfirst(request('platform')) }}
                    </div>
                @endif

                <button type="submit"
                        class="w-full py-3.5 rounded-xl bg-gradient-to-r from-brand-red to-brand-navy text-white font-bold hover:opacity-90 transition-opacity">
                    Kirim Masukan
                </button>

                <p class="text-xs text-gray-400 text-center">
                    Dengan mengirim formulir ini, kamu menyetujui <a href="{{ route('legal.privacy') }}" class="underline hover:text-brand-red">Kebijakan Privasi</a> kami.
                </p>
            </form>
        </div>
    </div>

@endsection
