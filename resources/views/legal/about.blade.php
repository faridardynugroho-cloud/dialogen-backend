@extends('legal.layout')

@section('title', 'Tentang Kami')
@section('meta_description', 'Kenali misi Dialogen dalam melestarikan bahasa daerah Indonesia melalui game kuis multiplayer yang interaktif dan menyenangkan.')

@section('content')

    {{-- HERO --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-brand-red via-brand-red/90 to-white" style="height: 420px;"></div>
        <div class="relative max-w-5xl mx-auto px-5 sm:px-8 pt-16 pb-24 text-center">
            <span class="inline-block px-4 py-1.5 rounded-full bg-white/15 text-white text-xs font-semibold tracking-wide uppercase backdrop-blur-sm border border-white/20">
                Tentang Dialogen
            </span>
            <h1 class="mt-6 text-3xl sm:text-5xl font-extrabold text-white leading-tight max-w-3xl mx-auto">
                Melestarikan Bahasa Daerah, Satu Kuis dalam Satu Waktu
            </h1>
            <p class="mt-5 text-white/90 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                Dialogen adalah platform kuis multiplayer real-time yang mengajak generasi muda mengenal kembali kekayaan bahasa daerah Indonesia lewat cara yang kompetitif, sosial, dan menyenangkan.
            </p>
        </div>
    </section>

    {{-- STATS STRIP --}}
    <section class="max-w-4xl mx-auto px-5 sm:px-8 -mt-14 relative z-10">
        <div class="bg-white rounded-2xl shadow-xl shadow-brand-navy/10 border border-gray-100 grid grid-cols-2 sm:grid-cols-5 divide-x divide-gray-100">
            @foreach ([
                ['label' => 'Jawa', 'emoji' => '🏯'],
                ['label' => 'Sunda', 'emoji' => '⛰️'],
                ['label' => 'Minangkabau', 'emoji' => '🏠'],
                ['label' => 'Bali', 'emoji' => '🌺'],
                ['label' => 'Bugis', 'emoji' => '⛵'],
            ] as $i => $lang)
                <div class="flex flex-col items-center justify-center py-5 px-2 {{ $i >= 4 ? 'col-span-2 sm:col-span-1' : '' }}">
                    <span class="text-2xl mb-1">{{ $lang['emoji'] }}</span>
                    <span class="text-xs sm:text-sm font-semibold text-brand-navy text-center">{{ $lang['label'] }}</span>
                </div>
            @endforeach
        </div>
    </section>

    {{-- MISI --}}
    <section class="max-w-4xl mx-auto px-5 sm:px-8 py-20">
        <div class="grid sm:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-brand-red font-bold text-sm uppercase tracking-wide">Misi Kami</span>
                <h2 class="mt-3 text-2xl sm:text-3xl font-extrabold text-brand-navy leading-snug">
                    Bahasa daerah adalah identitas yang tidak boleh punah.
                </h2>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    Menurut UNESCO, ratusan bahasa daerah di Indonesia berada dalam status terancam punah karena semakin sedikit penutur muda yang menggunakannya sehari-hari. Dialogen hadir sebagai jembatan antara teknologi modern dan warisan budaya — mengubah proses belajar bahasa daerah menjadi pengalaman yang kompetitif dan menyenangkan, bukan beban.
                </p>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    Setiap pertanyaan yang dijawab, setiap kata baru yang dipelajari, adalah langkah kecil untuk menjaga bahasa daerah tetap hidup di tangan generasi berikutnya.
                </p>
            </div>
            <div class="bg-gradient-to-br from-brand-navy to-brand-indigo rounded-2xl p-8 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mb-4 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                </svg>
                <p class="text-lg font-semibold leading-relaxed">
                    "Bahasa adalah rumah tempat jiwa suatu bangsa bersemayam. Kehilangan bahasa daerah sama dengan kehilangan sebagian dari diri kita."
                </p>
            </div>
        </div>
    </section>

    {{-- FITUR --}}
    <section class="bg-gray-50/70 py-20 border-y border-gray-100">
        <div class="max-w-5xl mx-auto px-5 sm:px-8">
            <div class="text-center max-w-xl mx-auto mb-14">
                <span class="text-brand-red font-bold text-sm uppercase tracking-wide">Fitur</span>
                <h2 class="mt-3 text-2xl sm:text-3xl font-extrabold text-brand-navy">Dibangun untuk Pengalaman Multiplayer yang Seru</h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ([
                    ['icon' => '🎮', 'title' => 'Kuis Real-time', 'desc' => 'Bermain bersama teman secara langsung dengan timer yang tersinkronisasi untuk semua pemain.'],
                    ['icon' => '✉️', 'title' => 'Message Chat', 'desc' => 'Kirim pesan langsung dengan sesama pemain di dalam room lewat fitur message chat terintegrasi.'],
                    ['icon' => '🏆', 'title' => 'Papan Skor Dinamis', 'desc' => 'Pantau peringkatmu secara real-time dengan animasi perubahan posisi yang responsif.'],
                    ['icon' => '🗺️', 'title' => '5 Bahasa Daerah', 'desc' => 'Jawa, Sunda, Minangkabau, Bali, dan Bugis — dengan konten yang terus bertambah.'],
                    ['icon' => '🚪', 'title' => 'Room Privat', 'desc' => 'Buat room sendiri dan undang teman lewat kode unik untuk sesi bermain bersama.'],
                    ['icon' => '🤖', 'title' => 'Soal Berbasis AI', 'desc' => 'Pertanyaan disusun dengan bantuan AI yang disesuaikan gaya bahasa tiap daerah.'],
                ] as $feature)
                    <div class="bg-white rounded-xl p-6 border border-gray-100 hover:border-brand-red/30 hover:shadow-lg hover:shadow-brand-red/5 transition-all">
                        <span class="text-3xl">{{ $feature['icon'] }}</span>
                        <h3 class="mt-4 font-bold text-brand-navy">{{ $feature['title'] }}</h3>
                        <p class="mt-2 text-sm text-gray-500 leading-relaxed">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TIM / PENGEMBANG --}}
    <section class="max-w-4xl mx-auto px-5 sm:px-8 py-20 text-center">
        <span class="text-brand-red font-bold text-sm uppercase tracking-wide">Di Balik Layar</span>
        <h2 class="mt-3 text-2xl sm:text-3xl font-extrabold text-brand-navy">Dikembangkan dengan Dedikasi</h2>
        <p class="mt-4 text-gray-600 max-w-xl mx-auto leading-relaxed">
            Dialogen dikembangkan secara independen sebagai upaya nyata memadukan teknologi mobile modern dengan budaya lokal Indonesia.
        </p>

        <div class="mt-10 flex justify-center">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-8 py-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-brand-red to-brand-navy flex items-center justify-center text-white font-extrabold text-lg">
                    A
                </div>
                <div class="text-left">
                    <p class="font-bold text-brand-navy">Ardy</p>
                    <p class="text-sm text-gray-500">Pengembang & Pencipta Dialogen</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="max-w-3xl mx-auto px-5 sm:px-8 pb-24">
        <div class="bg-gradient-to-r from-brand-red to-brand-navy rounded-2xl px-8 py-12 text-center text-white">
            <h2 class="text-2xl font-extrabold">Punya masukan atau menemukan bug?</h2>
            <p class="mt-2 text-white/85">Bantu kami membuat Dialogen lebih baik lagi.</p>
            <a href="{{ route('legal.feedback') }}" class="inline-block mt-6 px-6 py-3 rounded-xl bg-white text-brand-navy font-bold hover:bg-gray-100 transition-colors">
                Kirim Masukan
            </a>
        </div>
    </section>

@endsection
