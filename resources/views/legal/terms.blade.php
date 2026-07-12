@extends('legal.layout')

@section('title', 'Syarat & Ketentuan')
@section('meta_description', 'Syarat dan ketentuan penggunaan aplikasi Dialogen — aturan akun, perilaku pengguna, konten, dan tanggung jawab.')

@section('content')

    <section class="bg-brand-navy">
        <div class="max-w-4xl mx-auto px-5 sm:px-8 pt-14 pb-10">
            <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 text-white text-xs font-semibold tracking-wide uppercase border border-white/10">
                Legal
            </span>
            <h1 class="mt-5 text-3xl sm:text-4xl font-extrabold text-white">Syarat & Ketentuan</h1>
            <p class="mt-3 text-white/70 text-sm">Terakhir diperbarui: {{ $updatedAt ?? '12 Juli 2026' }}</p>
        </div>
    </section>

    <div class="max-w-4xl mx-auto px-5 sm:px-8 py-14 grid lg:grid-cols-[220px_1fr] gap-12">

        <aside class="hidden lg:block">
            <div class="sticky top-24">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-3">Daftar Isi</p>
                <ul class="space-y-2 text-sm text-gray-500 border-l border-gray-200">
                    <li><a href="#penerimaan" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Penerimaan Syarat</a></li>
                    <li><a href="#layanan" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Deskripsi Layanan</a></li>
                    <li><a href="#akun" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Akun Pengguna</a></li>
                    <li><a href="#perilaku" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Aturan Perilaku</a></li>
                    <li><a href="#konten" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Konten & Kekayaan Intelektual</a></li>
                    <li><a href="#penghentian" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Penghentian Akun</a></li>
                    <li><a href="#tanggung-jawab" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Batasan Tanggung Jawab</a></li>
                    <li><a href="#perubahan-layanan" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Perubahan Layanan</a></li>
                    <li><a href="#hukum" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Hukum yang Berlaku</a></li>
                    <li><a href="#kontak-tos" class="block pl-4 -ml-px border-l-2 border-transparent hover:border-brand-red hover:text-brand-red transition-colors">Kontak</a></li>
                </ul>
            </div>
        </aside>

        <article class="prose-legal max-w-none text-gray-700 leading-relaxed [&>section]:mb-12">

            <section id="penerimaan">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">1. Penerimaan Syarat</h2>
                <p>Dengan mengunduh, mengakses, atau menggunakan aplikasi Dialogen ("Layanan"), Anda menyatakan telah membaca, memahami, dan menyetujui untuk terikat oleh Syarat & Ketentuan ini beserta <a href="{{ route('legal.privacy') }}">Kebijakan Privasi</a> kami. Jika Anda tidak menyetujui salah satu bagian dari syarat ini, mohon untuk tidak menggunakan Layanan.</p>
            </section>

            <section id="layanan">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">2. Deskripsi Layanan</h2>
                <p>Dialogen adalah aplikasi permainan kuis multiplayer real-time bertema bahasa daerah Indonesia. Layanan memungkinkan pengguna untuk membuat atau bergabung ke dalam room permainan, menjawab pertanyaan seputar bahasa daerah, berkomunikasi melalui voice chat, dan melihat papan skor bersama pemain lain.</p>
                <p class="mt-3">Kami berupaya menjaga Layanan tetap tersedia, namun tidak menjamin operasional tanpa gangguan, kesalahan, atau downtime, mengingat sifat layanan real-time yang bergantung pada koneksi internet pengguna.</p>
            </section>

            <section id="akun">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">3. Akun Pengguna</h2>
                <ul class="list-disc pl-5 space-y-1.5">
                    <li>Anda bertanggung jawab untuk menjaga kerahasiaan kredensial akun dan kode room yang Anda buat atau miliki.</li>
                    <li>Anda setuju untuk memberikan nama pengguna yang tidak mengandung unsur SARA, kekerasan, ujaran kebencian, atau konten tidak pantas lainnya.</li>
                    <li>Anda bertanggung jawab penuh atas seluruh aktivitas yang terjadi melalui akun Anda.</li>
                    <li>Kami berhak menolak, menangguhkan, atau menghapus akun yang melanggar ketentuan ini tanpa pemberitahuan sebelumnya.</li>
                </ul>
            </section>

            <section id="perilaku">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">4. Aturan Perilaku Pengguna</h2>
                <p>Untuk menjaga Dialogen sebagai ruang yang aman dan menyenangkan bagi semua pengguna, Anda setuju untuk <strong>tidak</strong>:</p>
                <ul class="list-disc pl-5 space-y-1.5 mt-3">
                    <li>Melakukan kecurangan (cheating), eksploitasi bug, atau penggunaan alat pihak ketiga untuk memanipulasi skor atau hasil permainan.</li>
                    <li>Melakukan pelecehan, intimidasi, ujaran kebencian, atau perundungan terhadap pengguna lain, baik melalui teks maupun voice chat.</li>
                    <li>Membagikan kode room kepada pihak yang tidak berkepentingan dengan tujuan mengganggu jalannya permainan pengguna lain.</li>
                    <li>Menggunakan Layanan untuk tujuan ilegal, penipuan, atau menyebarkan konten yang melanggar hukum yang berlaku di Indonesia.</li>
                    <li>Mencoba mengakses, merusak, atau mengganggu infrastruktur server, API, maupun sistem keamanan Dialogen.</li>
                </ul>
                <p class="mt-3">Pelanggaran terhadap aturan ini dapat mengakibatkan penangguhan sementara atau permanen atas akses Anda ke Layanan.</p>
            </section>

            <section id="konten">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">5. Konten & Kekayaan Intelektual</h2>
                <p>Seluruh konten dalam aplikasi Dialogen — termasuk namun tidak terbatas pada logo, desain antarmuka, basis data pertanyaan kuis, dan kode sumber — adalah milik Dialogen dan dilindungi oleh hukum kekayaan intelektual yang berlaku. Anda tidak diperkenankan menyalin, mendistribusikan ulang, atau memodifikasi konten tersebut tanpa izin tertulis.</p>
                <p class="mt-3">Nama pengguna yang Anda buat tetap menjadi tanggung jawab Anda, namun Anda memberikan izin kepada Dialogen untuk menampilkannya dalam konteks permainan (room, papan skor) kepada pengguna lain.</p>
            </section>

            <section id="penghentian">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">6. Penghentian Akun</h2>
                <p>Anda dapat menghentikan penggunaan Layanan dan meminta penghapusan akun kapan saja melalui pengaturan aplikasi atau dengan menghubungi kami. Kami juga berhak menangguhkan atau menghentikan akses Anda ke Layanan apabila ditemukan pelanggaran terhadap Syarat & Ketentuan ini, tanpa kewajiban memberikan kompensasi dalam bentuk apapun.</p>
            </section>

            <section id="tanggung-jawab">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">7. Batasan Tanggung Jawab</h2>
                <p>Layanan disediakan "sebagaimana adanya" (as is) tanpa jaminan dalam bentuk apapun, baik tersurat maupun tersirat. Dialogen tidak bertanggung jawab atas:</p>
                <ul class="list-disc pl-5 space-y-1.5 mt-3">
                    <li>Kerugian yang timbul akibat gangguan koneksi internet, kegagalan perangkat, atau downtime server di luar kendali wajar kami.</li>
                    <li>Konten atau perilaku pengguna lain selama sesi voice chat maupun interaksi dalam room permainan.</li>
                    <li>Kehilangan data gameplay akibat force majeure atau insiden teknis yang tidak dapat dihindari.</li>
                </ul>
            </section>

            <section id="perubahan-layanan">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">8. Perubahan Layanan & Ketentuan</h2>
                <p>Kami berhak untuk mengubah, menangguhkan, atau menghentikan sebagian maupun seluruh fitur Layanan sewaktu-waktu. Kami juga dapat memperbarui Syarat & Ketentuan ini dari waktu ke waktu; penggunaan Layanan yang berkelanjutan setelah perubahan dianggap sebagai persetujuan Anda terhadap ketentuan yang telah diperbarui.</p>
            </section>

            <section id="hukum">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">9. Hukum yang Berlaku</h2>
                <p>Syarat & Ketentuan ini diatur dan ditafsirkan sesuai dengan hukum yang berlaku di Republik Indonesia. Setiap perselisihan yang timbul akan diselesaikan secara musyawarah terlebih dahulu sebelum menempuh jalur hukum yang berlaku.</p>
            </section>

            <section id="kontak-tos" class="!mb-0">
                <h2 class="text-xl font-extrabold text-brand-navy mb-4">10. Hubungi Kami</h2>
                <p>Jika Anda memiliki pertanyaan mengenai Syarat & Ketentuan ini, silakan hubungi kami melalui:</p>
                <div class="mt-4 bg-gray-50 rounded-xl p-6 border border-gray-100">
                    <p class="font-semibold text-brand-navy">Tim Dialogen</p>
                    <p class="text-sm text-gray-500 mt-1">Email: <a href="mailto:support@dialogen.app">support@dialogen.app</a></p>
                    <p class="text-sm text-gray-500 mt-1">Atau melalui formulir <a href="{{ route('legal.feedback') }}">Kirim Masukan</a> di dalam aplikasi.</p>
                </div>
            </section>

        </article>
    </div>

@endsection
