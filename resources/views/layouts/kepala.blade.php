<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Kepala OPD - E-SKM')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 antialiased">
    <div class="min-h-screen flex">

        {{-- SIDEBAR --}}
        <aside class="w-[260px] bg-white border-r border-slate-200 flex flex-col">
            <div class="flex items-center gap-3 px-4 py-6">
                <div class="h-10 w-10 rounded-2xl bg-[#0B5394] flex items-center justify-center text-white font-bold">E</div>
                <div>
                    <div class="font-bold text-slate-900 leading-tight">E-SKM</div>
                    <div class="text-xs text-slate-500">Kota Parepare</div>
                </div>
            </div>

            <nav class="flex-1 px-2 space-y-2">
                <a href="{{ route('kepala.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl border
                    {{ request()->routeIs('kepala.dashboard') ? 'border-[#0B5394] bg-[#0B5394]/10 text-[#0B5394] font-semibold' : 'border-slate-200 bg-white hover:bg-slate-50' }}">
                    Dashboard
                </a>
            </nav>

            <div class="px-4 py-6 border-t border-slate-200">
                <div class="text-xs text-slate-500">Login sebagai</div>
                <div class="font-semibold text-slate-800">{{ auth()->user()->name }}</div>
                <div class="text-xs text-slate-500">OPD: {{ auth()->user()->opd_kode }}</div>
            </div>
        </aside>

        {{-- AREA KANAN --}}
        <div class="flex-1 flex flex-col">

            {{-- HEADER --}}
            <header class="bg-white border-b border-slate-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <div class="text-lg font-bold text-slate-900">@yield('page_title')</div>
                        <div class="text-sm text-slate-500">@yield('page_desc')</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-4 py-2 rounded-xl bg-[#0B5394] text-white text-sm font-semibold hover:opacity-95">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            {{-- KONTEN --}}
            <main class="flex-1 px-6 py-6">
                @yield('content')
            </main>
        </div>

    </div>
</body>
</html>