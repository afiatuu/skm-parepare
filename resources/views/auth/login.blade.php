<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login – E-SKM Kota Parepare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

{{-- BACKGROUND --}}
<div class="min-h-screen w-full flex items-center justify-center relative"
     style="background-image: url('{{ asset('img/patunghainun.jpg') }}');
            background-size: cover;
            background-position: center;">
    <div class="absolute inset-0 bg-white/40 backdrop-blur-sm"></div>

    {{-- CARD LOGIN --}}
    <div class="relative z-10 w-full max-w-4xl bg-white rounded-3xl shadow-lg 
                overflow-hidden flex items-stretch max-h-[430px]">

        {{-- LEFT PANEL --}}
        <div class="w-1/2 bg-[#003A78] text-white px-10 py-6 flex flex-col relative">

            {{-- Link Beranda --}}
            <a href="{{ route('home') }}"
            class="absolute top-4 left-8 text-[11px] underline hover:text-blue-200">
                kembali ke Beranda
            </a>

            {{-- Tengah tapi rata kiri --}}
            <div class="flex-1 flex items-center px-8">
                <div>
                    <p class="text-2xl font-semibold leading-tight mb-4">
                        Hi,<br>
                        Selamat Datang Di<br>
                        SKM Kota Parepare
                    </p>

                    <p class="text-[12px] text-blue-100 mt-6">
                        Silahkan masuk untuk melanjutkan ke sistem.
                    </p>
                </div>
            </div>
        </div>

        {{-- RIGHT PANEL (FORM) --}}
        <div class="w-1/2 bg-white px-10 py-6 flex flex-col justify-center">

            {{-- Logo Header --}}
            <div class="flex items-center justify-center gap-3 mb-6">
                <img src="{{ asset('img/logo kampus.png') }}" class="h-9 object-contain" alt="">
                <img src="{{ asset('img/Lambang_Kota_Parepare.png') }}" class="h-9 object-contain" alt="">
                <div class="leading-tight">
                    <p class="text-sm font-semibold text-slate-800">E-SKM</p>
                    <p class="text-[11px] text-slate-600">Kota Parepare</p>
                </div>
            </div>

            {{-- Error --}}
            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-50 text-sm text-red-700 border border-red-200">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form Login --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-[13px] font-medium mb-1">Email</label>
                    <input type="email" name="email"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-[13px]
                               focus:ring-2 focus:ring-[#0B5394] focus:border-[#0B5394]"
                        required>
                </div>

                <div>
                    <label class="block text-[13px] font-medium mb-1">Password</label>
                    <input type="password" name="password"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-[13px]
                               focus:ring-2 focus:ring-[#0B5394] focus:border-[#0B5394]"
                        required>
                </div>

                <div class="flex items-center justify-between text-[12px]">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" class="rounded border-slate-400">
                        Ingat Saya
                    </label>
                    <a href="{{ route('password.request') }}" class="underline hover:text-[#0B5394]">
                        Lupa Password?
                    </a>
                </div>

                <button type="submit"
                    class="w-full bg-[#002B6B] hover:bg-[#001f4a] text-white text-[14px] 
                           font-semibold rounded-full py-2.5 mt-2 transition">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>