{{-- resources/views/survey/opd-select.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Pilih OPD – Survei Kepuasan Masyarakat</title>
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

    {{-- KONTEN --}}
    <main class="flex-1 w-full">
        <div class="max-w-5xl mx-auto mt-8 mb-12 px-4">

            <h1 class="text-center text-[18px] md:text-[20px] font-semibold text-slate-900">
                Survei Kepuasan Masyarakat Kota Parepare
            </h1>

            <p class="mt-2 text-center text-[13px] text-slate-600">
                Silakan pilih Organisasi Perangkat Daerah (OPD) yang ingin Anda nilai.
            </p>

            <section class="mt-6 flex justify-center">
                <div class="w-full max-w-4xl bg-[#E8F0FB] rounded-[10px] border border-[#D0D9EE] px-8 py-8">

                    <h2 class="text-center text-[16px] md:text-[18px] font-semibold text-slate-900 mb-6">
                        Pilih OPD
                    </h2>

                    <form method="POST" action="{{ route('survey.opd.select.post') }}">
                        @csrf

                        <div class="flex flex-wrap items-center justify-center gap-4 md:gap-6">
                            @foreach ($kategoriOpd as $slug => $label)
                                <button
                                    type="submit"
                                    name="kategori"
                                    value="{{ $slug }}"
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
                    </form>
              </div>
            </section>
        </div>
    </main>

</div>

</body>
</html>