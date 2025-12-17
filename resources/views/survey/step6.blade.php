{{-- resources/views/survey/step6.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Survei Kepuasan Masyarakat – Langkah 6</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white antialiased">

<div class="min-h-screen flex flex-col bg-white">

    {{-- HEADER --}}
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

    {{-- KONTEN UTAMA --}}
    <main class="flex-1 w-full">
        <div class="max-w-5xl mx-auto mt-8 mb-12 px-4">

            {{-- Judul utama --}}
            <h1 class="text-center text-[18px] md:text-[20px] font-semibold text-slate-900">
                Selamat Datang di Survei Kepuasan Masyarakat&nbsp; Kota Parepare
            </h1>

            {{-- Progress bar --}}
            <div class="mt-4 flex justify-center">
                <div class="w-full max-w-3xl">
                    <div class="h-2 rounded-full bg-slate-200 overflow-hidden">
                        <div
                            class="h-full bg-[#0B5394] transition-all duration-500"
                            style="width: {{ $progressPercent ?? 35 }}%;"
                        ></div>
                    </div>
                </div>
            </div>

            {{-- CARD BIRU --}}
            <section class="mt-6 flex justify-center">
                <div class="w-full max-w-4xl bg-[#E8F0FB] rounded-[10px] border border-[#D0D9EE] px-8 py-10">

                    <h2 class="text-center text-[16px] md:text-[18px] font-semibold text-slate-900 mb-6">
                        Silahkan Pilih Kecamatan
                    </h2>

                    @error('kecamatan')
                        <p class="mb-4 text-center text-[12px] text-red-600">{{ $message }}</p>
                    @enderror

                    @php
                        $selected = old('kecamatan', session('survey.kecamatan'));
                    @endphp

                    <form method="POST" action="{{ route('survey.step6.post') }}">
                        @csrf

                        {{-- 4 kartu kecamatan dalam satu baris --}}
                        <div class="flex items-center justify-center gap-4 md:gap-6 flex-wrap">

                            @foreach ($kecamatanOptions as $opt)
                                <label class="cursor-pointer">
                                    <input
                                        type="radio"
                                        name="kecamatan"
                                        value="{{ $opt }}"
                                        class="peer sr-only"
                                        @checked($selected === $opt)
                                        onchange="this.form.submit()"
                                    >
                                    <div
                                        class="w-28 h-32 md:w-32 md:h-36 bg-white rounded-2xl shadow-md
                                            flex items-center justify-center text-center
                                            border border-slate-200
                                            peer-checked:border-[#0B5394] peer-checked:ring-2 peer-checked:ring-[#0B5394]
                                            hover:shadow-lg hover:-translate-y-0.5 transition"
                                    >
                                        <span class="px-3 text-[13px] md:text-[14px] font-medium text-slate-800">
                                            {{ $opt }}
                                        </span>
                                    </div>
                                </label>
                            @endforeach

                        </div>

                        {{-- Tombol Kembali --}}
                        <div class="mt-6 flex justify-start">
                            <a href="{{ route('survey.step5') }}"
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