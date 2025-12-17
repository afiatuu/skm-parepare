{{-- resources/views/survey/opd-detail.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $opd['nama'] }} – Survei Kepuasan Masyarakat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#E6EDF7] antialiased">

<div class="min-h-screen flex flex-col">

    {{-- =================== HEADER (sama seperti step) =================== --}}
    <header class="w-full border-b border-slate-200 bg-white">
        <div class="max-w-5xl mx-auto px-4 md:px-6 py-3 flex items-center justify-center gap-8">
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/logo kampus.png') }}" class="h-9 w-auto object-contain" alt="Logo Kampus">
                <span class="text-[11px] leading-tight text-slate-800">
                    Institut Teknologi<br>
                    Bacharuddin Jusuf Habibie
                </span>
            </div>

            <div class="flex items-center gap-2">
                <img src="{{ asset('img/Lambang_Kota_Parepare.png') }}" class="h-9 w-auto object-contain" alt="Logo Kota Parepare">
                <div class="leading-tight">
                    <p class="text-[11px] font-semibold text-slate-800">E-SKM</p>
                    <p class="text-[11px] text-slate-600">Kota Parepare</p>
                </div>
            </div>
        </div>
    </header>

    {{-- =================== KONTEN =================== --}}
    <main class="flex-1 w-full">
        <div class="max-w-5xl mx-auto mt-8 mb-10 px-4 md:px-0">

            {{-- KARTU BESAR (full lebar dalam container) --}}
            <section class="w-full bg-white rounded-[18px] border border-slate-200 shadow-sm overflow-hidden">

                <div class="grid grid-cols-1 md:grid-cols-[260px,1fr] min-h-[360px]">

                    {{-- PANEL KIRI: info singkat + tombol mulai (tema biru) --}}
                    <div class="bg-gradient-to-b from-[#0B5394] to-[#051D41] text-white p-6 md:p-8 flex flex-col gap-6">

                        <div>
                            <p class="text-[13px]">Survei Kepuasan</p>
                            <p class="text-[22px] font-semibold leading-tight">Masyarakat</p>
                            <p class="mt-1 text-[12px] text-blue-100">
                                Tahun {{ $tahunSurvey }}
                            </p>
                        </div>

                        <div class="flex flex-col items-center gap-3">
                            <div class="w-28 h-28 rounded-full border-[6px] border-white/60 flex items-center justify-center bg-white shadow-md">
                                <span class="text-[22px] font-bold text-[#0B5394]">
                                    {{ number_format($rataRataIkm, 2) }}
                                </span>
                            </div>

                            {{-- bintang dibuat putih supaya serasi --}}
                            <div class="flex items-center gap-1 text-lg text-white/90">
                                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            </div>

                            <p class="text-[13px] text-blue-50">
                                {{ $jumlahResponden }} Responden
                            </p>
                        </div>

                        <div class="flex justify-center">
                            <a href="{{ route('survey.step1') }}"
                               class="inline-flex items-center justify-center px-6 py-2.5 rounded-full
                                      bg-white text-[#0B5394] text-[13px] font-semibold shadow-md
                                      hover:bg-slate-100 transition">
                                Beri Penilaian
                                <span class="ml-1">➜</span>
                            </a>
                        </div>

                        <div class="mt-auto border-t border-white/30 pt-3 text-[10px] text-blue-100">
                            <p>Penilaian Mutu Pelayanan berbasis Indeks Kepuasan Masyarakat (IKM).</p>
                        </div>
                    </div>

                    {{-- PANEL KANAN: nama OPD + indikator --}}
                    <div class="bg-white p-6 md:p-8 flex flex-col">
                        <h2 class="text-[18px] md:text-[20px] font-semibold text-[#0B5394] mb-4 md:mb-6">
                            {{ cleanLabel($opd['nama']) }}
                        </h2>

                        <div class="space-y-3 flex-1">
                            @foreach ($indikator as $idx => $namaIndikator)
                                @php
                                    $nilai = $nilaiIndikator[$idx] ?? 0;
                                    $percent = $nilai > 0 ? min(100, ($nilai / 6) * 100) : 0;
                                @endphp
                                <div class="flex items-center gap-3">
                                    <div class="w-1/2 md:w-1/3">
                                        <p class="text-[12px] md:text-[13px] text-slate-800">
                                            {{ $namaIndikator }}
                                        </p>
                                    </div>
                                    <div class="flex-1">
                                        <div class="h-2.5 rounded-full bg-slate-200 overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-[#0B5394] to-[#2F80ED]"
                                                 style="width: {{ $percent }}%;"></div>
                                        </div>
                                    </div>
                                    <div class="w-12 text-right">
                                        <p class="text-[12px] text-slate-700">
                                            {{ $nilai > 0 ? number_format($nilai, 2) : '-' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 flex items-center gap-2 text-[11px] text-slate-600">
                            <div class="w-4 h-4 border border-slate-300 rounded-sm"></div>
                            <span>Skala 6 (0–6). Nilai di atas masih berupa contoh / placeholder.</span>
                        </div>
                    </div>

                </div>
            </section>

        </div>
    </main>

</div>

</body>
</html>