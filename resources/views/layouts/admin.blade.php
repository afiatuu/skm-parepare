{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Dashboard') – E-SKM Kota Parepare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-800">
@php
    $brand = '#0B5394';
    $brandSoft = '#E8F0FB';
@endphp

<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="hidden md:flex w-72 flex-col bg-white border-r border-slate-200">
        <div class="px-6 py-6">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center h-12 w-12 rounded-2xl bg-white">
                    <img src="{{ asset('img/Lambang_Kota_Parepare.png') }}" 
                        alt="Logo Kota Parepare" 
                        class="h-10 w-10 object-contain">
                </div>
                <div class="leading-tight">
                    <p class="font-semibold text-slate-900">E-SKM</p>
                    <p class="text-xs text-slate-500">Kota Parepare</p>
                </div>
            </div>
        </div>

        @php
            $isActive = fn($name) => request()->routeIs($name);
            $item = fn($active) => $active
                ? 'bg-[#E8F0FB] border border-[#D0D9EE] text-slate-900 font-semibold'
                : 'border border-transparent text-slate-700 hover:bg-slate-50';
        @endphp

        <div class="px-6 pb-6">
            <p class="text-[11px] font-semibold tracking-wider text-slate-400">MENU UTAMA</p>

            <nav class="mt-3 space-y-2 text-sm">
                <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ $item($isActive('admin.dashboard')) }}">
                    <span class="h-2 w-2 rounded-full" style="background: {{ $isActive('admin.dashboard') ? $brand : '#CBD5E1' }};"></span>
                    Ringkasan SKM
                </a>

                <a href="{{ route('admin.dinas_layanan') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ $item($isActive('admin.dinas_layanan')) }}">
                    <span class="h-2 w-2 rounded-full" style="background: {{ $isActive('admin.dinas_layanan') ? $brand : '#CBD5E1' }};"></span>
                    Data OPD & Layanan
                </a>

                <a href="{{ route('admin.pertanyaan_skm') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ $item($isActive('admin.pertanyaan_skm')) }}">
                    <span class="h-2 w-2 rounded-full" style="background: {{ $isActive('admin.pertanyaan_skm') ? $brand : '#CBD5E1' }};"></span>
                    Pertanyaan SKM
                </a>

                <a href="{{ route('admin.hasil_survei') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ $item($isActive('admin.hasil_survei')) }}">
                    <span class="h-2 w-2 rounded-full" style="background: {{ $isActive('admin.hasil_survei') ? $brand : '#CBD5E1' }};"></span>
                    Hasil Survei
                </a>

                <a href="{{ route('admin.laporan_ikm') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ $item($isActive('admin.laporan_ikm')) }}">
                    <span class="h-2 w-2 rounded-full" style="background: {{ $isActive('admin.laporan_ikm') ? $brand : '#CBD5E1' }};"></span>
                    Laporan IKM
                </a>

                <a href="{{ route('admin.arsip.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ $item($isActive('admin.arsip.index')) }}">
                    <span class="h-2 w-2 rounded-full"
                        style="background: {{ $isActive('admin.arsip.index') ? $brand : '#CBD5E1' }};"></span>
                    Arsip Laporan
                </a>
            </nav>

            <p class="text-[11px] font-semibold tracking-wider text-slate-400 mt-8">PENGATURAN</p>
            <nav class="mt-3 space-y-2 text-sm">
                <a href="{{ route('admin.profil') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ $item($isActive('admin.profil')) }}">
                    <span class="h-2 w-2 rounded-full"
                        style="background: {{ $isActive('admin.profil') ? $brand : '#CBD5E1' }};"></span>
                    Profil Akun
                </a>
            </nav>
        </div>

        <div class="mt-auto px-6 py-5 border-t border-slate-200">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-2xl border border-slate-200 bg-slate-50 flex items-center justify-center font-semibold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- TOPBAR --}}
        <header class="bg-white border-b border-slate-200">
            <div class="px-4 md:px-8 py-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="md:hidden h-10 w-10 rounded-2xl text-white flex items-center justify-center font-bold shadow-sm"
                         style="background: {{ $brand }};">
                        E
                    </div>

                    <div class="min-w-0">
                        <h1 class="text-lg md:text-xl font-bold text-slate-900 truncate">
                            @yield('page_title', 'Dashboard')
                        </h1>
                        <p class="text-xs text-slate-500 truncate">
                            @yield('page_subtitle', 'Panel Admin E-SKM Kota Parepare')
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    {{-- LOGOUT (tinggi konsisten) --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="h-11 px-5 rounded-2xl text-sm font-semibold text-white shadow-sm hover:opacity-95"
                                style="background: {{ $brand }};">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 px-4 md:px-8 py-6">
            @yield('content')
        </main>

        <footer class="px-4 md:px-8 py-4 text-xs text-slate-500">
            © {{ date('Y') }} E-SKM Kota Parepare • Admin Panel
        </footer>
    </div>
</div>
</body>
</html>