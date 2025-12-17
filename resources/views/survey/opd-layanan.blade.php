{{-- resources/views/survey/opd-layanan.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Pilih Layanan – Survei Kepuasan Masyarakat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white antialiased">

<div class="min-h-screen flex flex-col bg-white">

    {{-- Header --}}
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

    <main class="flex-1 w-full">
        <div class="max-w-5xl mx-auto mt-8 mb-12 px-4">

            <h1 class="text-center text-[18px] md:text-[20px] font-semibold text-slate-900">
                Pilih Jenis Layanan
            </h1>

            <p class="mt-2 text-center text-[13px] text-slate-600">
                OPD terpilih: <span class="font-semibold">{{ cleanLabel($dinas->nama) }}</span>
            </p>

            <section class="mt-6 flex justify-center">
                <div class="w-full max-w-4xl bg-[#E8F0FB] rounded-[10px] border border-[#D0D9EE] px-6 md:px-8 py-8">

                    <form method="POST" action="{{ route('survey.opd.layanan.post', $dinas->id) }}">
                        @csrf

                        <div class="max-w-xl mx-auto">
                            <label class="block text-[13px] font-semibold text-slate-800 mb-2">
                                Jenis layanan
                            </label>

                            <select name="service_id" required
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-[13px]
                                       focus:outline-none focus:ring-2 focus:ring-[#0B5394]">
                                <option value="">-- Pilih layanan --</option>

                                @foreach($layananOptions as $layanan)
                                    <option value="{{ $layanan->id }}" @selected(old('service_id') == $layanan->id)>
                                        {{ cleanLabel($layanan->nama) }}
                                    </option>
                                @endforeach
                            </select>

                            @error('service_id')
                                <p class="mt-2 text-[12px] text-red-600">{{ $message }}</p>
                            @enderror

                            <div class="mt-6 flex items-center justify-between">
                                <a href="{{ route('survey.opd.byKategori', session('survey.kategori_opd_slug', 'dinas')) }}"
                                   class="px-5 py-2.5 rounded-full border border-slate-300 text-[13px]
                                          text-slate-700 bg-white hover:bg-slate-50">
                                    Kembali
                                </a>

                                <button type="submit"
                                    class="px-6 py-2.5 rounded-full bg-[#0B5394] text-white text-[13px]
                                           font-semibold hover:bg-[#083b69]">
                                    Lanjut
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </section>

        </div>
    </main>

</div>

</body>
</html>