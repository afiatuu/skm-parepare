<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Operator - E-SKM')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-[280px] bg-white border-r border-slate-200 hidden md:flex flex-col">
        <div class="px-6 py-5 flex items-center gap-3">
            <div class="h-11 w-11 rounded-2xl bg-[#0B5394] text-white flex items-center justify-center font-bold">
                E
            </div>
            <div>
                <div class="font-semibold leading-tight">E-SKM</div>
                <div class="text-xs text-slate-500 leading-tight">Kota Parepare</div>
            </div>
        </div>

        <div class="px-6">
            <div class="text-xs font-semibold text-slate-500 tracking-wider mb-3">MENU OPERATOR</div>

            <nav class="space-y-2">
                <a href="{{ route('operator.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl border
                        {{ request()->routeIs('operator.dashboard') ? 'border-[#0B5394] bg-[#0B5394]/10 text-[#0B5394] font-semibold' : 'border-slate-200 bg-white hover:bg-slate-50' }}">
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('operator.data-responden') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl border
                        {{ request()->routeIs('operator.data-responden') ? 'border-[#0B5394] bg-[#0B5394]/10 text-[#0B5394] font-semibold' : 'border-slate-200 bg-white hover:bg-slate-50' }}">
                    <span>Data Responden</span>
                </a>

                <a href="{{ route('operator.laporan-ikm') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl border
                        {{ request()->routeIs('operator.laporan-ikm') ? 'border-[#0B5394] bg-[#0B5394]/10 text-[#0B5394] font-semibold' : 'border-slate-200 bg-white hover:bg-slate-50' }}">
                    <span>Laporan IKM</span>
                </a>
            </nav>
        </div>

        <div class="mt-auto px-6 py-5 border-t border-slate-200">
            <div class="text-xs text-slate-500">Login sebagai</div>
            <div class="font-semibold">{{ auth()->user()->name }}</div>
            <div class="text-xs text-slate-500 mt-1">OPD: <span class="font-medium text-slate-700">{{ auth()->user()->opd_kode ?? '-' }}</span></div>
        </div>
    </aside>

    {{-- CONTENT --}}
    <div class="flex-1 min-w-0">

        {{-- TOPBAR --}}
        <header class="bg-white border-b border-slate-200">
            <div class="px-4 md:px-8 py-4 flex items-center justify-between gap-4">
                <div>
                    <div class="text-xl font-bold">Dashboard Operator</div>
                    <div class="text-sm text-slate-500">Ringkasan survei, responden, dan nilai IKM OPD</div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden md:flex items-center gap-2 px-4 py-2 rounded-2xl border border-slate-200 bg-white">
                        <svg class="h-5 w-5 text-slate-400" viewBox="0 0 24 24" fill="none">
                            <path d="M21 21l-4.3-4.3m1.3-5.2a7 7 0 11-14 0 7 7 0 0114 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <input class="outline-none text-sm w-64" placeholder="Cari (responden / layanan)..." />
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="px-5 py-2.5 rounded-2xl bg-[#0B5394] text-white font-semibold hover:opacity-95">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="px-4 md:px-8 py-8">
            @yield('content')
        </main>

    </div>
</div>
</body>
</html>