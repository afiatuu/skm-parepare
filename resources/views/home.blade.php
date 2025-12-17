<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>E-SKM Kota Parepare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>

    <style>
    @keyframes float-slow {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-10px); }
    }

    .animate-float-slow {
        animation: float-slow 6s ease-in-out infinite;
    }
    </style>

</head>
<body class="bg-white text-slate-900 antialiased">

    {{-- ===================== NAVBAR (FIXED) ===================== --}}
    <header class="fixed top-0 inset-x-0 z-20 bg-white/90 backdrop-blur border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-6 py-3 flex items-center justify-between">
            {{-- Logo kiri --}}
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1">
                    <div class="h-10 w-10 rounded-full overflow-hidden flex items-center justify-center bg-white">
                        <img src="{{ asset('img/logo kampus.png') }}" alt="Logo ITBH"
                             class="h-full w-full object-contain">
                    </div>
                    <div class="h-10 w-10 rounded-full overflow-hidden flex items-center justify-center bg-white">
                        <img src="{{ asset('img/Lambang_Kota_Parepare.png') }}" alt="Logo Kota Parepare"
                             class="h-full w-full object-contain">
                    </div>
                </div>
                <div class="ml-2 leading-tight">
                    <p class="text-xs font-semibold text-slate-800">E-SKM</p>
                    <p class="text-[11px] text-slate-600">Kota Parepare</p>
                </div>
            </div>

            {{-- Menu tengah --}}
            <nav class="hidden md:flex items-center gap-2 text-xs font-medium bg-[#002B6B] text-white px-4 py-1.5 rounded-full shadow-sm">
                <a href="#beranda"
                   class="px-3 py-1 rounded-full hover:bg-white hover:text-[#002B6B] transition">
                    Beranda
                </a>
                <a href="#tentang"
                   class="px-3 py-1 rounded-full hover:bg-white hover:text-[#002B6B] transition">
                    Tentang E-SKM
                </a>
                <a href="#unsur"
                   class="px-3 py-1 rounded-full hover:bg-white hover:text-[#002B6B] transition">
                    Unsur Survei
                </a>
                <a href="#publikasi"
                   class="px-3 py-1 rounded-full hover:bg-white hover:text-[#002B6B] transition">
                    Publikasi
                </a>
                <a href="#kontak"
                   class="px-3 py-1 rounded-full hover:bg-white hover:text-[#002B6B] transition">
                    Hubungi Kami
                </a>
            </nav>

            {{-- Login --}}
            <div>
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center rounded-full bg-[#002B6B] text-white text-xs font-semibold px-6 py-2 shadow-sm hover:bg-[#001c46]">
                    Login
                </a>
            </div>
        </div>
    </header>

    {{-- Offset supaya konten tidak ketutupan header --}}
    <main class="pt-20">

        {{-- ===================== BERANDA ===================== --}}
        <section id="beranda" class="relative min-h-screen flex items-center">
            {{-- Background blur --}}
            <div class="absolute inset-0">
                <img src="{{ asset('img/patunghainun.jpg') }}"
                     alt="Gerbang Kota Parepare"
                     class="w-full h-full object-cover filter blur-sm scale-105">
                <div class="absolute inset-0 bg-gradient-to-r from-[#002B6B]/70 via-[#002B6B]/60 to-transparent"></div>
            </div>

            {{-- Konten --}}
            <div class="relative max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
                <div class="text-white space-y-5">
                    <h1 class="text-3xl md:text-4xl font-semibold leading-tight">
                        Survei Kepuasan Masyarakat<br>
                        Kota Parepare
                    </h1>
                    <p class="text-sm md:text-[13px] leading-relaxed text-blue-100">
                        Survei Kepuasan Masyarakat (SKM) adalah kegiatan pengukuran secara komprehensif
                        tentang peningkatan kepuasan masyarakat terhadap kualitas layanan yang diberikan
                        oleh penyelenggara pelayanan publik.
                    </p>
                    <a href="{{ route('survey.opd.select') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-white text-[#002B6B] text-sm font-semibold px-7 py-2.5 shadow-md hover:bg-blue-50">
                        Mulai Survei
                        <span class="text-lg">➜</span>
                    </a>
                </div>

                <div class="hidden md:flex justify-end">
                    {{-- placeholder ilustrasi / gambar --}}
                    <div class="bg-white/90 rounded-3xl shadow-lg px-8 py-8 max-w-md text-sm text-slate-700">
                        <p class="font-semibold text-[#002B6B] mb-2">E-SKM Kota Parepare</p>
                        <p>
                            Hasil Survei Kepuasan Masyarakat menjadi dasar perbaikan kualitas pelayanan
                            di berbagai OPD, mulai dari dinas, kecamatan, hingga layanan kesehatan.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===================== TENTANG & DASAR HUKUM ===================== --}}
        <section id="tentang" class="min-h-screen flex items-center bg-white">
            <div class="max-w-6xl mx-auto px-6 py-16 md:py-24 grid md:grid-cols-[3fr,2fr] gap-10 items-center">
                <div>
                    <h2 class="text-2xl md:text-[26px] font-semibold mb-3">
                        Tentang &amp; Dasar Hukum E-SKM
                    </h2>
                    <div class="w-16 h-0.5 bg-[#002B6B] mb-6"></div>

                    <div class="space-y-3 text-[13px] leading-relaxed text-slate-800">
                        <p>
                            Survei Kepuasan Masyarakat (SKM) adalah kegiatan pengukuran secara komprehensif
                            tentang peningkatan kepuasan masyarakat terhadap kualitas layanan yang diberikan
                            oleh penyelenggara pelayanan publik.
                        </p>
                        <p>
                            Hasil pengukuran dari kegiatan survei berupa Indeks Kepuasan Masyarakat (IKM)
                            yang ditetapkan dengan skala 1 (satu) sampai dengan 4 (empat).
                        </p>
                        <p>
                            Dasar hukum penyusunan indeks kepuasan masyarakat diatur dalam Permenpan-RB
                            Nomor 14 Tahun 2017 tentang Pedoman Penyusunan Survei Kepuasan Masyarakat
                            Penyelenggara Pelayanan Publik.
                        </p>
                        <p>
                            Survei ini diharapkan mendorong partisipasi masyarakat sebagai pengguna layanan
                            untuk menilai kinerja penyelenggara pelayanan dan menjadi bahan perbaikan
                            kualitas pelayanan publik secara berkelanjutan.
                        </p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('survey.opd.select') }}"
                           class="inline-flex items-center gap-2 rounded-full bg-[#002B6B] text-white text-sm font-semibold px-6 py-2 shadow-md hover:bg-[#001c46]">
                            Mulai Survei
                            <span class="text-lg">➜</span>
                        </a>
                    </div>
                </div>

                <div class="flex justify-center md:justify-end">
                    <div class="animate-float-slow">
                            <img src="{{ asset('img/tentang.png') }}"
                                alt="Ilustrasi Survei Online"
                                class="w-64 md:w-72 h-auto object-contain">
                        </div>
                    </div>
                </div>
        </section>

        {{-- ===================== UNSUR E-SKM (INTERAKTIF) ===================== --}}
        <section id="unsur" class="min-h-screen flex items-center bg-[#F7F8FC]">
            <div class="max-w-6xl mx-auto px-6 py-16 md:py-24">
                <h2 class="text-2xl md:text-[26px] font-semibold text-center mb-2">
                    Unsur E-SKM
                </h2>
                <p class="text-[11px] text-center text-slate-600 max-w-3xl mx-auto mb-10">
                    Kuesioner Survei Kepuasan Masyarakat disusun berdasarkan 9 (sembilan) unsur pelayanan
                    sebagaimana diatur dalam Permenpan-RB Nomor 14 Tahun 2017. Klik salah satu unsur di bawah
                    untuk melihat penjelasannya.
                </p>

                <div class="grid md:grid-cols-[1.3fr,1.7fr] gap-8 items-start">
                    {{-- daftar unsur --}}
                    <ul class="space-y-2 text-[14px]">
                        @php
                            $unsurList = [
                                1 => 'Persyaratan',
                                2 => 'Sistem, Mekanisme, dan Prosedur',
                                3 => 'Waktu Penyelesaian',
                                4 => 'Biaya/Tarif',
                                5 => 'Produk Spesifikasi Jenis Pelayanan',
                                6 => 'Kompetensi Pelaksana',
                                7 => 'Perilaku Pelaksana',
                                8 => 'Penanganan Pengaduan, Saran, dan Masukan',
                                9 => 'Sarana dan Prasarana',
                            ];
                        @endphp

                        @foreach ($unsurList as $idx => $label)
                            <li>
                                <button
                                    type="button"
                                    class="unsur-item w-full text-left px-4 py-2 rounded-full border border-transparent
                                           hover:border-[#002B6B] hover:bg-white shadow-sm transition text-sm
                                           {{ $idx === 1 ? 'bg-white border-[#002B6B] shadow-md font-semibold text-[#002B6B]' : 'bg-white/70 text-slate-800' }}"
                                    data-unsur="{{ $idx }}"
                                >
                                    {{ $label }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    {{-- kartu penjelasan --}}
                    <div class="bg-gradient-to-br from-[#002B6B] to-[#3B82F6] text-white rounded-3xl shadow-lg p-7 md:p-9 flex flex-col justify-between min-h-[260px]">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-blue-100 mb-1">Penjelasan Unsur</p>
                            <h3 id="unsurTitle" class="text-xl font-semibold mb-4">
                                Persyaratan
                            </h3>
                            <p id="unsurText" class="text-[13px] leading-relaxed text-blue-100">
                                Syarat yang harus dipenuhi dalam pengurusan suatu jenis pelayanan,
                                baik persyaratan teknis maupun administratif.
                            </p>
                        </div>
                        <div class="mt-6 text-[11px] text-blue-100">
                            Unsur penilaian ini menjadi dasar perhitungan Indeks Kepuasan Masyarakat (IKM)
                            yang digunakan untuk menilai mutu pelayanan publik.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===================== PUBLIKASI IKM ===================== --}}
        <section id="publikasi" class="scroll-mt-28 px-10 py-12 bg-[#F3F6FF]">
            <h2 class="text-[20px] font-semibold text-center text-slate-900 mb-2">
                Publikasi IKM
            </h2>
            <div class="w-24 h-1 bg-[#002B6B] mx-auto mb-4 rounded-full"></div>

            <p class="text-[12px] md:text-[13px] text-center text-slate-600 max-w-2xl mx-auto mb-10">
                Ringkasan hasil Survei Kepuasan Masyarakat (SKM) per OPD di Kota Parepare.
                Berisi nilai IKM, jumlah responden, dan akses ke laporan lengkap.
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                @foreach ($cards as $card)
                    <div class="relative bg-gradient-to-b from-[#E7F1FF] to-[#BFD1F5]
                            rounded-[32px] shadow-md flex flex-col items-center justify-between
                            pt-8 pb-10 px-6 overflow-hidden min-h-[360px]">
                        {{-- nama OPD --}}
                        <div class="mt-4 text-center">
                            <h3 class="text-[15px] font-semibold text-slate-900 leading-snug">
                                {{ $card['nama'] }}
                            </h3>
                            <p class="mt-1 text-[11px] uppercase tracking-wide text-slate-600">
                                {{ $card['sub'] }}
                            </p>
                        </div>

                        {{-- gambar publikasi --}}
                        <div class="flex justify-center items-center h-24 w-24 mb-4">
                            <img src="{{ asset('img/publikasi.png') }}"
                                alt="Ilustrasi publikasi SKM"
                                class="h-full w-full object-contain drop-shadow-sm">
                        </div>

                        {{-- rating bintang sesuai nilai IKM --}}
                        <div class="mb-6 flex justify-center">
                            <div class="flex gap-1 text-[#FFB400] text-base">
                                @for ($i = 0; $i < $card['stars']; $i++)
                                    ★
                                @endfor
                                @for ($i = $card['stars']; $i < 5; $i++)
                                    ☆
                                @endfor
                            </div>
                        </div>

                        {{-- tombol detail --}}
                        <a href="{{ $card['url'] }}"
                        class="mt-auto inline-flex items-center gap-2 rounded-full
                                border border-[#002B6B] text-[#002B6B] text-[12px]
                                font-semibold px-5 py-2 bg-white/90
                                hover:bg-[#002B6B] hover:text-white transition">
                            Lihat Detail
                            <span class="text-sm">➜</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- ===================== HUBUNGI KAMI ===================== --}}
        <section id="kontak" class="min-h-screen flex items-center bg-gradient-to-b from-[#E7F0FF] to-[#99B7F2]">
            <div class="max-w-6xl mx-auto px-6 py-16 md:py-24">
                <h2 class="text-2xl md:text-[26px] font-semibold text-center mb-6">
                    Hubungi Kami
                </h2>

                <div class="max-w-xl mx-auto bg-white/90 rounded-3xl shadow-md px-8 py-8 text-[13px] text-slate-800">
                    <p class="font-semibold mb-1">
                        Institut Teknologi Bacharuddin Jusuf Habibie
                    </p>
                    <p>
                        Jl. Balaikota No.1, Bumi Harapan, Kec. Bacukiki Barat,<br>
                        Kota Parepare, Sulawesi Selatan 91122
                    </p>
                </div>
            </div>
        </section>

    </main>

    {{-- ===================== SCRIPT UNSUR INTERAKTIF ===================== --}}
    <script>
        const unsurDescriptions = {
            1: 'Syarat yang harus dipenuhi dalam pengurusan suatu jenis pelayanan, baik persyaratan teknis maupun administratif.',
            2: 'Tata cara pelayanan yang dibakukan bagi pemberi dan penerima pelayanan, termasuk pengaduan.',
            3: 'Jangka waktu yang diperlukan untuk menyelesaikan seluruh proses pelayanan dari setiap jenis pelayanan.',
            4: 'Ongkos yang dikenakan kepada penerima layanan dalam mengurus dan/atau memperoleh pelayanan dari penyelenggara yang besarnya ditetapkan berdasarkan kesepakatan antara penyelenggara dan masyarakat.',
            5: 'Hasil pelayanan yang diberikan dan diterima sesuai dengan ketentuan yang telah ditetapkan. Produk pelayanan ini merupakan hasil dari setiap spesifikasi jenis pelayanan.',
            6: 'Kemampuan yang harus dimiliki oleh pelaksana meliputi pengetahuan, keahlian, keterampilan, dan pengalaman.',
            7: 'Sikap petugas dalam memberikan pelayanan.',
            8: 'Tata cara pelaksanaan penanganan pengaduan dan tindak lanjut.',
            9: 'Sarana adalah segala sesuatu yang dapat dipakai sebagai alat dalam mencapai maksud dan tujuan. Prasarana adalah segala sesuatu yang merupakan penunjang utama terselenggaranya suatu proses. Sarana digunakan untuk benda yang bergerak (komputer, mesin) dan prasarana untuk benda yang tidak bergerak (gedung).',
        };

        const unsurTitle = document.getElementById('unsurTitle');
        const unsurText  = document.getElementById('unsurText');
        const unsurButtons = document.querySelectorAll('.unsur-item');

        unsurButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.unsur;

                // update card
                unsurTitle.textContent = btn.textContent.trim();
                unsurText.textContent  = unsurDescriptions[id] ?? '';

                // styling active button
                unsurButtons.forEach(b => {
                    b.classList.remove('bg-white', 'border-[#002B6B]', 'shadow-md', 'font-semibold', 'text-[#002B6B]');
                    b.classList.add('bg-white/70', 'text-slate-800', 'border-transparent');
                });

                btn.classList.remove('bg-white/70', 'text-slate-800', 'border-transparent');
                btn.classList.add('bg-white', 'border-[#002B6B]', 'shadow-md', 'font-semibold', 'text-[#002B6B]');
            });
        });
    </script>

</body>
</html>