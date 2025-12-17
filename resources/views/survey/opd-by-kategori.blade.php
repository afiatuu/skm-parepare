{{-- resources/views/survey/opd-by-kategori.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Kategori {{ $kategoriLabel }} – Survei Kepuasan Masyarakat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white antialiased">

<div class="min-h-screen flex flex-col bg-white">

    {{-- =================== HEADER (sama seperti step) =================== --}}
    <header class="w-full border border-slate-200 rounded-b-[18px] bg-white">
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
        <div class="max-w-5xl mx-auto mt-8 mb-12 px-4">

            {{-- Judul utama (sama dengan step lain) --}}
            <h1 class="text-center text-[18px] md:text-[20px] font-semibold text-slate-900">
                Survei Kepuasan Masyarakat Kota Parepare
            </h1>

            <p class="mt-2 text-center text-[13px] text-slate-600">
                Silakan pilih salah satu unit pelayanan pada
                <span class="font-semibold">Kategori {{ $kategoriLabel }}</span>.
            </p>

            {{-- Card biru tengah --}}
            <section class="mt-6 flex justify-center">
                <div class="w-full max-w-4xl bg-[#E8F0FB] rounded-[10px] border border-[#D0D9EE] px-8 py-10">

                    {{-- JUDUL CARD menyesuaikan kategori --}}
                    <h2 class="text-center text-[16px] md:text-[18px] font-semibold text-slate-900 mb-6">
                        @if ($kategori === 'dinas')
                            Kategori Dinas
                        @elseif ($kategori === 'kesehatan')
                            Kategori Layanan Kesehatan
                        @else
                            Kategori Kecamatan
                        @endif
                    </h2>

                    <form method="POST" action="{{ route('survey.opd.byKategori.post', $kategori) }}">
                        @csrf

                        {{-- Kartu-kartu pilihan OPD, ukuran disamakan dengan step lain --}}
                        <div class="flex flex-wrap items-center justify-center gap-4 md:gap-6">
                            @foreach ($opsi as $id => $label)
                                <button
                                    type="submit"
                                    name="opd"
                                    value="{{ $id }}"
                                    class="w-28 h-32 md:w-32 md:h-36 bg-white rounded-2xl shadow-md
                                        flex items-center justify-center text-center
                                        border border-slate-200 px-3
                                        hover:border-[#0B5394] hover:ring-2 hover:ring-[#0B5394]
                                        hover:shadow-lg hover:-translate-y-0.5 transition"
                                >
                                    <span class="text-[13px] md:text-[14px] font-semibold text-slate-900">
                                        {{ cleanLabel($label) }}
                                    </span>
                                </button>
                            @endforeach
                        </div>

                        {{-- Tombol kembali ke pilih kategori --}}
                        <div class="mt-6 flex justify-start">
                            <a href="{{ route('survey.opd.select') }}"
                               class="px-5 py-2.5 rounded-full border border-slate-300 text-[13px]
                                      text-slate-700 bg-white hover:bg-slate-50">
                                Kembali
                            </a>
                        </div>
                    </form>

                </div>
            </section>
        </div>
    </main>

</div>

</body>
</html>