{{-- resources/views/layouts/survey.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Survei Kepuasan Masyarakat Kota Parepare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F6FB] antialiased">

<div class="min-h-screen flex flex-col bg-[#F4F6FB]">

    {{-- HEADER --}}
    <header class="w-full border-b border-slate-200 bg-white">
        <div class="max-w-6xl mx-auto px-4 md:px-6 py-3 flex items-center justify-center gap-8">
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/logo kampus.png') }}" class="h-9 w-auto" alt="Logo Kampus">
                <span class="text-[11px] leading-tight text-slate-800">
                    Institut Teknologi<br>Bacharuddin Jusuf Habibie
                </span>
            </div>

            <div class="flex items-center gap-2">
                <img src="{{ asset('img/Lambang_Kota_Parepare.png') }}" class="h-9 w-auto" alt="Logo Kota Parepare">
                <div class="leading-tight">
                    <p class="text-[11px] font-semibold text-slate-800">E-SKM</p>
                    <p class="text-[11px] text-slate-600">Kota Parepare</p>
                </div>
            </div>
        </div>
    </header>

    {{-- KONTEN --}}
    <main class="flex-1 w-full">
        <div class="max-w-5xl mx-auto mt-10 mb-12 px-4">

            {{-- Judul utama --}}
            <h1 class="text-center text-[18px] md:text-[20px] font-semibold text-slate-900">
                Selamat Datang di Survei Kepuasan Masyarakat&nbsp; Kota Parepare
            </h1>

            {{-- Progress bar --}}
            <div class="mt-6 flex justify-center">
                <div class="w-full max-w-3xl">
                    <div class="h-2 rounded-full bg-slate-200 overflow-hidden">
                        <div class="h-full bg-[#0B5394] transition-all duration-500"
                             style="width: {{ $progressPercent ?? 0 }}%;"></div>
                    </div>
                </div>
            </div>

            {{-- CARD TENGAH --}}
            <section class="mt-8 flex justify-center">
                <div class="w-full max-w-3xl bg-[#E8F0FB] border border-[#D0D9EE]
                            rounded-2xl shadow-sm px-6 md:px-10 py-10">

                    <h2 class="text-center text-[16px] md:text-[18px] font-semibold text-slate-900 mb-6">
                        @yield('card-title')
                    </h2>

                    @yield('card-body')
                </div>
            </section>
        </div>
    </main>

</div>

</body>
</html>