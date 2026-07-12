@extends('legal.layout')

@section('title', 'Kebijakan Privasi')
@section('meta_description', 'Kebijakan privasi Dialogen: data apa saja yang kami kumpulkan, bagaimana kami menggunakannya, dan hak-hak Anda sebagai pengguna.')

@section('content')

    {{-- HEADER --}}
    <section class="bg-brand-navy">
        <div class="max-w-4xl mx-auto px-5 sm:px-8 pt-14 pb-10">
            <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 text-white text-xs font-semibold tracking-wide uppercase border border-white/10">
                Legal
            </span>
            <h1 class="mt-5 text-3xl sm:text-4xl font-extrabold text-white">Kebijakan Privasi</h1>
            <p class="mt-3 text-white/70 text-sm">Terakhir diperbarui: {{ $updatedAt ?? '12 Juli 2026' }}</p>
        </div>
    </section>

    <div class="max-w-4xl mx-auto px-5 sm:px-8 py-14 grid lg:grid-cols-[220px_1fr] gap-12">

        {{-- TOC --}}
        <aside class="hidden lg:block">
            <div class="sticky top-24">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-3">Daftar Isi</p>
                <ul class="space-y-2 text-sm text-gray-500 border-l border-gray-200">
                    <li><a href="#pendahuluan" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Pendahuluan</a></li>
                    <li><a href="#data-dikumpulkan" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Data yang Dikumpulkan</a></li>
                    <li><a href="#penggunaan-data" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Penggunaan Data</a></li>
                    <li><a href="#message-chat" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Message Chat</a></li>
                    <li><a href="#pihak-ketiga" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Pihak Ketiga</a></li>
                    <li><a href="#penyimpanan" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Penyimpanan & Keamanan</a></li>
                    <li><a href="#hak-pengguna" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Hak Pengguna</a></li>
                    <li><a href="#anak" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Privasi Anak</a></li>
                    <li><a href="#perubahan" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Perubahan Kebijakan</a></li>
                    <li><a href="#kontak" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Kontak</a></li>
                </ul>
            </div>
        </aside>

        {{-- CONTENT --}}
        <article class="prose-legal max-w-none text-gray-700 leading-relaxed [&>section]:mb-12">

            <section id="pendahuluan">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">1. Pendahuluan</h2>
                <p>Dialogen ("kami", "aplikasi") menghargai privasi setiap pengguna ("Anda"). Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi Anda saat menggunakan aplikasi Dialogen di perangkat mobile maupun melalui situs web pendukungnya.</p>
                <p class="mt-3">Dengan mengunduh, mengakses, atau menggunakan Dialogen, Anda menyetujui praktik yang dijelaskan dalam kebijakan ini. Jika Anda tidak menyetujui kebijakan ini, mohon untuk tidak menggunakan aplikasi.</p>
            </section>

            <section id="data-dikumpulkan">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">2. Data yang Kami Kumpulkan</h2>

                <h3 class="font-bold text-brand-navy mt-6 mb-2">2.1 Informasi yang Anda Berikan</h3>
                <ul class="list-disc pl-5 space-y-1.5">
                    <li><strong>Nama pengguna (username)</strong> — ditampilkan kepada pemain lain di dalam room permainan.</li>
                    <li><strong>Kode room</strong> — dibuat otomatis saat Anda membuat atau bergabung ke sebuah sesi permainan.</li>
                    <li><strong>Konten masukan</strong> — pesan yang Anda kirimkan melalui formulir feedback atau laporan bug, termasuk alamat email jika Anda mencantumkannya secara sukarela.</li>
                </ul>

                <h3 class="font-bold text-brand-navy mt-6 mb-2">2.2 Informasi yang Dikumpulkan Otomatis</h3>
                <ul class="list-disc pl-5 space-y-1.5">
                    <li><strong>Data gameplay</strong> — skor, jawaban, waktu respons, dan riwayat pertandingan yang tersimpan selama sesi berlangsung untuk keperluan papan skor.</li>
                    <li><strong>Informasi perangkat</strong> — jenis perangkat, sistem operasi, dan versi aplikasi, digunakan untuk keperluan debugging dan kompatibilitas.</li>
                    <li><strong>Data koneksi</strong> — alamat IP sementara digunakan oleh layanan WebSocket (Laravel Reverb) dan message chat untuk menjaga koneksi real-time tetap stabil.</li>
                </ul>

                <h3 class="font-bold text-brand-navy mt-6 mb-2">2.3 Informasi yang Tidak Kami Kumpulkan</h3>
                <p>Dialogen <strong>tidak meminta</strong> data sensitif seperti nomor identitas, data keuangan, atau lokasi presisi (GPS). Kami juga tidak meminta akses ke kontak, galeri foto, atau kamera perangkat Anda.</p>
            </section>

            <section id="penggunaan-data">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">3. Bagaimana Kami Menggunakan Data</h2>
                <p>Data yang dikumpulkan digunakan semata-mata untuk:</p>
                <ul class="list-disc pl-5 space-y-1.5 mt-3">
                    <li>Menjalankan fungsi inti aplikasi — pembuatan room, sinkronisasi pertanyaan, dan perhitungan skor secara real-time.</li>
                    <li>Menampilkan nama pengguna dan peringkat kepada pemain lain dalam room yang sama.</li>
                    <li>Memperbaiki bug, meningkatkan performa, dan mengembangkan fitur baru berdasarkan laporan pengguna.</li>
                    <li>Berkomunikasi dengan Anda apabila Anda mengirimkan laporan bug atau masukan yang memerlukan tindak lanjut.</li>
                </ul>
                <p class="mt-3">Kami <strong>tidak menjual, menyewakan, atau memperdagangkan</strong> data pribadi Anda kepada pihak ketiga untuk tujuan pemasaran.</p>
            </section>

            <section id="message-chat">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">4. Message Chat</h2>
                <p>Dialogen menyediakan fitur message chat berbasis teknologi Websocket untuk memungkinkan komunikasi langsung antar pemain dalam satu room.</p>
                <ul class="list-disc pl-5 space-y-1.5 mt-3">
                    <li>Pesan <strong>diteruskan secara real-time (live) dan tidak dipantau maupun disimpan</strong> di server kami.</li>
                    <li>Koneksi pesan diproses melalui server reverb untuk menjaga kualitas dan stabilitas komunikasi antar pemain.</li>
                    <li>Anda dapat mengabaikan pesan masuk pada message chat kapan saja didalam room permainan.</li>
                </ul>
                <p class="mt-3">Kami menghimbau pengguna untuk menjaga etika berkomunikasi dalam message chat, sebagaimana diatur dalam <a href="{{ route('legal.terms') }}">Syarat & Ketentuan</a> kami.</p>
            </section>

            <section id="pihak-ketiga">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">5. Layanan Pihak Ketiga</h2>
                <p>Untuk menjalankan fitur-fiturnya, Dialogen menggunakan sejumlah layanan pihak ketiga:</p>
                <div class="mt-4 overflow-hidden rounded-xl border border-gray-200">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-brand-navy">
                            <tr>
                                <th class="text-left font-bold px-4 py-3">Layanan</th>
                                <th class="text-left font-bold px-4 py-3">Tujuan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="px-4 py-3 font-medium">Server Infrastruktur (Cloud Hosting)</td>
                                <td class="px-4 py-3 text-gray-500">Menjalankan API, WebSocket, dan server message chat.</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-medium">Layanan AI Pihak Ketiga</td>
                                <td class="px-4 py-3 text-gray-500">Menghasilkan konten pertanyaan kuis berbahasa daerah.</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 font-medium">Penyedia Toko Aplikasi (Google Play)</td>
                                <td class="px-4 py-3 text-gray-500">Distribusi, pembaruan, dan statistik unduhan aplikasi.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="mt-3 text-sm text-gray-500">Setiap layanan pihak ketiga tunduk pada kebijakan privasinya masing-masing.</p>
            </section>

            <section id="penyimpanan">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">6. Penyimpanan & Keamanan Data</h2>
                <p>Kami menerapkan langkah-langkah teknis yang wajar untuk melindungi data Anda, termasuk enkripsi koneksi (HTTPS/WSS) dan pembatasan akses ke basis data. Namun demikian, tidak ada metode transmisi data melalui internet yang 100% aman.</p>
                <p class="mt-3">Data gameplay (skor, riwayat pertandingan) disimpan selama diperlukan untuk fungsi papan skor dan dapat dihapus secara berkala.</p>
            </section>

            <section id="hak-pengguna">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">7. Hak Pengguna</h2>
                <p>Sebagai pengguna, Anda berhak untuk:</p>
                <ul class="list-disc pl-5 space-y-1.5 mt-3">
                    <li>Mengakses dan meminta salinan data pribadi yang kami simpan tentang Anda.</li>
                    <li>Meminta koreksi atas data yang tidak akurat.</li>
                    <li><strong>Meminta penghapusan data pribadi</strong> melalui fitur di dalam aplikasi atau dengan menghubungi kami melalui halaman <a href="{{ route('legal.feedback') }}">Kirim Masukan</a>.</li>
                </ul>
                <p class="mt-3">Permintaan penghapusan data akan kami proses dalam waktu yang wajar, kecuali terdapat kewajiban hukum untuk menyimpan data tersebut.</p>
            </section>

            <section id="anak">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">8. Privasi Anak</h2>
                <p>Dialogen tidak ditujukan untuk anak di bawah usia 13 tahun. Kami tidak dengan sengaja mengumpulkan data pribadi dari anak di bawah usia tersebut. Jika Anda mengetahui bahwa seorang anak telah memberikan data pribadi kepada kami tanpa persetujuan orang tua/wali, mohon segera hubungi kami agar data tersebut dapat dihapus.</p>
            </section>

            <section id="perubahan">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">9. Perubahan Kebijakan Privasi</h2>
                <p>Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu untuk mencerminkan perubahan pada praktik kami atau untuk alasan operasional, hukum, maupun regulasi lainnya. Perubahan signifikan akan diinformasikan melalui aplikasi atau halaman ini, beserta tanggal pembaruan terbaru.</p>
            </section>

            <section id="kontak" class="!mb-0">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">10. Hubungi Kami</h2>
                <p>Jika Anda memiliki pertanyaan, keluhan, atau permintaan terkait data pribadi Anda, silakan hubungi kami melalui:</p>
                <div class="mt-4 bg-gray-50 rounded-xl p-6 border border-gray-100">
                    <p class="font-semibold text-brand-navy">Tim Dialogen</p>
                    <p class="text-sm text-gray-500 mt-1">Email: <a href="mailto:dialogen.app@gmail.com">dialogen.app@gmail.com</a></p>
                    <p class="text-sm text-gray-500 mt-1">Atau melalui formulir <a href="{{ route('legal.feedback') }}">Kirim Masukan</a> di dalam aplikasi.</p>
                </div>
            </section>

        </article>
    </div>

@endsection
