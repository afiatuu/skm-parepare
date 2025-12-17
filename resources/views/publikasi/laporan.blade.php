<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan & Analisa IKM – E-SKM Kota Parepare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#E6EDF7] antialiased">

    {{-- HEADER --}}
    <header class="w-full bg-white shadow-sm border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-6 py-3 flex items-center justify-between">
            {{-- Logo + teks --}}
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1">
                    <div class="h-10 w-10 rounded-full overflow-hidden flex items-center justify-center bg-white border border-slate-200">
                        <img src="{{ asset('img/logo kampus.png') }}" alt="Logo ITBH"
                             class="h-full w-full object-contain">
                    </div>
                    <div class="h-10 w-10 rounded-full overflow-hidden flex items-center justify-center bg-white border border-slate-200">
                        <img src="{{ asset('img/Lambang_Kota_Parepare.png') }}" alt="Logo Kota Parepare"
                             class="h-full w-full object-contain">
                    </div>
                </div>
                <div class="ml-2 leading-tight">
                    <p class="text-xs font-semibold text-slate-800">E-SKM</p>
                    <p class="text-[11px] text-slate-600">Kota Parepare</p>
                </div>
            </div>

            {{-- Tombol kembali ke beranda --}}
            <a href="{{ url('/') }}"
               class="inline-flex items-center gap-2 rounded-full bg-[#002B6B] text-white
                      text-[11px] font-semibold px-5 py-2 shadow-sm hover:bg-[#001c46]">
                ← Kembali ke Beranda
            </a>
        </div>
    </header>

    {{-- KONTEN --}}
    <main class="max-w-6xl mx-auto px-6 py-8">
        <div class="bg-white rounded-3xl shadow-md border border-slate-200 overflow-hidden">
            {{-- Judul --}}
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h1 class="text-lg md:text-xl font-semibold text-slate-900">
                        Laporan &amp; Analisa Indeks Kepuasan Masyarakat
                    </h1>
                    <p class="text-[12px] text-slate-600 mt-1">
                        Rekapitulasi hasil survei per OPD di lingkungan Pemerintah Kota Parepare.
                    </p>
                </div>

                {{-- Search kecil --}}
                <div class="hidden md:flex items-center gap-2">
                    <label for="search" class="text-[11px] text-slate-500">Cari</label>
                    <input id="search" type="text" placeholder="ketik &amp; enter"
                           class="border border-slate-300 rounded-full px-3 py-1.5 text-[11px] focus:outline-none focus:ring-1 focus:ring-[#002B6B] focus:border-[#002B6B]">
                </div>
            </div>

            {{-- TABEL --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-[12px] text-left text-slate-800">
                    <thead class="bg-[#F3F6FF] border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-2 w-10">No</th>
                            <th class="px-4 py-2">Nama OPD</th>
                            <th class="px-4 py-2 text-center w-28">Responden</th>
                            <th class="px-4 py-2 text-center w-28">Nilai IKM</th>
                            <th class="px-4 py-2 text-center w-28">Rating</th>
                            <th class="px-4 py-2 text-center w-28">Publikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($opdList as $row)
                            <tr class="{{ $loop->odd ? 'bg-white' : 'bg-slate-50' }} border-b border-slate-100">
                                <td class="px-4 py-2 align-top">{{ $row['no'] }}</td>
                                <td class="px-4 py-2 align-top">
                                    {{ $row['opd_nama'] }}
                                </td>
                                <td class="px-4 py-2 text-center align-top">
                                    {{ $row['responden'] }}
                                </td>
                                <td class="px-4 py-2 text-center align-top">
                                    {{ $row['ikm'] ? number_format($row['ikm'], 2) : 'not-set' }}
                                </td>
                                <td class="px-4 py-2 text-center align-top">
                                    <div class="flex gap-1 text-yellow-500 text-sm justify-center">
                                        @for ($i = 0; $i < $row['stars']; $i++)
                                            ★
                                        @endfor
                                        @for ($i = $row['stars']; $i < 5; $i++)
                                            ☆
                                        @endfor
                                    </div>
                                </td>
                                <td class="px-4 py-2 text-center align-top">
                                    <a href="{{ $row['detail_url'] }}"
                                    class="text-[11px] text-[#002B6B] font-semibold hover:underline inline-flex items-center gap-1">
                                        Publikasi
                                        <span>➜</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>