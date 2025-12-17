<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Survei Kepuasan – Step 17</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white antialiased">

<div class="min-h-screen flex flex-col bg-white">

    {{-- ============== HEADER (SAMA DENGAN STEP LAIN) ============== --}}
    <header class="w-full border border-slate-200 rounded-b-[18px] bg-white">
        <div class="max-w-5xl mx-auto px-4 md:px-6 py-3 flex items-center justify-center gap-8">

            <div class="flex items-center gap-2">
                <img src="{{ asset('img/logo kampus.png') }}" class="h-9 w-auto object-contain">
                <span class="text-[11px] leading-tight text-slate-800">
                    Institut Teknologi<br>
                    Bacharuddin Jusuf Habibie
                </span>
            </div>

            <div class="flex items-center gap-2">
                <img src="{{ asset('img/Lambang_Kota_Parepare.png') }}" class="h-9 w-auto object-contain">
                <div class="leading-tight">
                    <p class="text-[11px] font-semibold text-slate-800">E-SKM</p>
                    <p class="text-[11px] text-slate-600">Kota Parepare</p>
                </div>
            </div>

        </div>
    </header>

    {{-- ============== KONTEN ============== --}}
    <main class="flex-1 w-full">
        <div class="max-w-5xl mx-auto mt-8 mb-12 px-4">

            {{-- Judul --}}
            <h1 class="text-center text-[18px] md:text-[20px] font-semibold text-slate-900">
                Selamat Datang di Survei Kepuasan Masyarakat&nbsp; Kota Parepare
            </h1>

            {{-- PROGRESS BAR --}}
            <div class="mt-4 flex justify-center">
                <div class="w-full max-w-3xl">
                    <div class="h-2 rounded-full bg-slate-200 overflow-hidden">
                        <div
                            class="h-full bg-[#0B5394] transition-all duration-500"
                            style="width: {{ $progressPercent }}%;"
                        ></div>
                    </div>
                </div>
            </div>

            {{-- CARD BIRU --}}
            <section class="mt-6 flex justify-center">
                <div class="w-full max-w-4xl bg-[#E8F0FB] rounded-[10px] border border-[#D0D9EE] px-8 py-10">

                    <p class="text-center text-[14px] md:text-[15px] font-semibold text-slate-900">
                        Untuk perbaikan pelayanan kami, silahkan sampaikan saran/keluhan Anda di sini :
                    </p>

                    <form method="POST" action="{{ route('survey.step17.post') }}" class="mt-6">
                        @csrf

                        <div class="flex justify-center">
                            <textarea
                                name="saran"
                                rows="4"
                                class="w-full max-w-3xl rounded-lg border border-slate-300 bg-white
                                       px-4 py-3 text-[13px] text-slate-800
                                       focus:outline-none focus:ring-2 focus:ring-[#0B5394] focus:border-[#0B5394]"
                                placeholder="Tuliskan saran atau keluhan Anda di sini...">{{ old('saran', $saran) }}</textarea>
                        </div>

                        @error('saran')
                            <p class="mt-2 text-center text-[12px] text-red-600">{{ $message }}</p>
                        @enderror

                        <div class="mt-6 flex items-center justify-between">

                            {{-- Kembali ke step 16 --}}
                            <a href="{{ route('survey.step16') }}"
                               class="px-5 py-2.5 rounded-full border border-slate-300 text-[13px]
                                      text-slate-700 bg-white hover:bg-slate-50">
                                Kembali
                            </a>

                            {{-- Tombol Kirim --}}
                            <button type="submit"
                                class="px-8 py-2.5 rounded-full bg-[#0B5394] text-white text-[13px]
                                       font-semibold shadow-md hover:bg-[#06336a]">
                                Kirim
                            </button>
                        </div>

                    </form>
                </div>
            </section>

        </div>
    </main>

</div>

</body>
</html>
