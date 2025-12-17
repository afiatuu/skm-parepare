{{-- resources/views/survey/step1.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Survei Kepuasan Masyarakat – Langkah 1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white antialiased">

<div class="min-h-screen flex flex-col bg-white">

    {{-- =================== HEADER =================== --}}
    <header class="w-full border border-slate-200 rounded-b-[18px] bg-white">
        <div class="max-w-5xl mx-auto px-4 md:px-6 py-3 flex items-center justify-center gap-8">

            {{-- Logo kampus + teks --}}
            <div class="flex items-center gap-2">
                <img
                    src="{{ asset('img/logo kampus.png') }}"
                    alt="Logo Kampus"
                    class="h-9 w-auto object-contain"
                >
                <span class="text-[11px] leading-tight text-slate-800">
                    Institut Teknologi<br>
                    Bacharuddin Jusuf Habibie
                </span>
            </div>

            {{-- Logo kota + teks E-SKM --}}
            <div class="flex items-center gap-2">
                <img
                    src="{{ asset('img/Lambang_Kota_Parepare.png') }}"
                    alt="Logo Kota Parepare"
                    class="h-9 w-auto object-contain"
                >
                <div class="leading-tight">
                    <p class="text-[11px] font-semibold text-slate-800">E-SKM</p>
                    <p class="text-[11px] text-slate-600">Kota Parepare</p>
                </div>
            </div>

        </div>
    </header>

    {{-- ============== KONTEN UTAMA ================= --}}
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
                            style="width: {{ $progressPercent ?? 6 }}%;"
                        ></div>
                    </div>
                </div>
            </div>

            {{-- ===== CARD BIRU ===== --}}
            <section class="mt-6 flex justify-center">
                <div class="w-full max-w-4xl bg-[#E8F0FB] rounded-[10px] border border-[#D0D9EE] px-8 py-8">

                    <h2 class="text-center text-[16px] md:text-[18px] font-semibold text-slate-900 mb-6">
                        Isi Data
                    </h2>

                    <form method="POST" action="{{ route('survey.step1.post') }}">
                        @csrf

                        {{-- BLOK INPUT DIPUSATKAN --}}
                        <div class="space-y-5 max-w-xl mx-auto">

                            {{-- No WA aktif --}}
                            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
                                <label for="no_wa"
                                       class="w-full md:w-40 text-[13px] font-medium text-slate-800 md:text-right">
                                    No. WA aktif <span class="text-red-500">*</span>
                                </label>

                                <div class="w-full md:flex-1 md:max-w-sm">
                                    <input
                                        type="text"
                                        id="no_wa"
                                        name="no_wa"
                                        value="{{ old('no_wa', session('survey.no_wa')) }}"
                                        placeholder="081234567890"
                                        class="w-full rounded-md border border-slate-300 bg-white px-3 py-1.5 text-[13px]
                                               focus:outline-none focus:ring-2 focus:ring-[#0B5394] focus:border-[#0B5394]"
                                        required
                                    >
                                    @error('no_wa')
                                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Nama --}}
                            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
                                <label for="nama"
                                       class="w-full md:w-40 text-[13px] font-medium text-slate-800 md:text-right">
                                    Nama <span class="text-red-500">*</span>
                                </label>

                                <div class="w-full md:flex-1 md:max-w-sm">
                                    <input
                                        type="text"
                                        id="nama"
                                        name="nama"
                                        value="{{ old('nama', session('survey.nama')) }}"
                                        placeholder="Masukkan nama lengkap Anda"
                                        class="w-full rounded-md border border-slate-300 bg-white px-3 py-1.5 text-[13px]
                                               focus:outline-none focus:ring-2 focus:ring-[#0B5394] focus:border-[#0B5394]"
                                        required
                                    >
                                    @error('nama')
                                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Pilih Layanan (dari tabel services) --}}
                            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4 mt-2">
                                <label for="service_id"
                                       class="w-full md:w-40 text-[13px] font-medium text-slate-800 md:text-right">
                                    Layanan yang diterima <span class="text-red-500">*</span>
                                </label>

                                <div class="w-full md:flex-1">
                                    <select
                                        id="service_id"
                                        name="service_id"
                                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-[13px]
                                               focus:outline-none focus:ring-2 focus:ring-[#2F80ED] focus:border-[#2F80ED]"
                                        required
                                    >
                                        <option value="">-- Pilih Layanan --</option>

                                        @foreach ($layananOptions as $opt)
                                            <option value="{{ $opt->id }}"
                                                @selected((string)old('service_id', session('survey.service_id')) === (string)$opt->id)>
                                                {{ $opt->nama }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('service_id')
                                        <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div> {{-- end max-w-xl mx-auto --}}

                        {{-- Pesan privasi (tetap di tengah) --}}
                        <p class="mt-4 text-center text-[12px] text-slate-600">
                            Data yang Anda berikan akan dijaga kerahasiaannya sesuai ketentuan yang berlaku.
                        </p>

                        {{-- Tombol Selanjutnya --}}
                        <div class="mt-6 flex justify-center">
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-8 py-2.5 rounded-full
                                           bg-[#0B5394] text-white text-[13px] font-semibold shadow-md
                                           hover:bg-[#08396A] transition">
                                Selanjutnya
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