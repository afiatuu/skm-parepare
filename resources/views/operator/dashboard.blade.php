@extends('layouts.operator')

@section('title', 'Dashboard Operator - E-SKM')

@section('content')
    {{-- HERO --}}
    <section class="rounded-[24px] overflow-hidden border border-slate-200 bg-white">
        <div class="p-6 md:p-8 bg-gradient-to-r from-[#0B5394] to-[#0EA5E9] text-white">
            <div class="text-xs uppercase tracking-wider opacity-90">E-SURVEY KEPUASAN MASYARAKAT</div>
            <div class="mt-2 text-3xl md:text-4xl font-extrabold">
                Selamat datang, {{ $user->name }} 👋
            </div>
            <p class="mt-2 text-white/90 max-w-3xl">
                Anda login sebagai operator untuk OPD: <span class="font-semibold">{{ $opdKode }}</span>.
                Pantau responden dan nilai IKM OPD Anda di sini.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('home') }}"
                   class="px-5 py-2.5 rounded-2xl bg-white text-[#0B5394] font-semibold hover:bg-white/95">
                    Buka Beranda Publik
                </a>
                <a href="#latest"
                   class="px-5 py-2.5 rounded-2xl border border-white/40 bg-white/10 text-white font-semibold hover:bg-white/15">
                    Lihat Respon Terbaru
                </a>
            </div>
        </div>
    </section>

    {{-- STATS --}}
    <section class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="rounded-2xl bg-white border border-slate-200 p-6">
            <div class="text-xs text-slate-500 uppercase tracking-wider">Responden Hari Ini</div>
            <div class="mt-2 text-3xl font-extrabold text-slate-900">{{ $respondenHariIni }}</div>
            <div class="mt-1 text-sm text-slate-500">Total input survei hari ini</div>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-6">
            <div class="text-xs text-slate-500 uppercase tracking-wider">Responden Bulan Ini</div>
            <div class="mt-2 text-3xl font-extrabold text-slate-900">{{ $respondenBulanIni }}</div>
            <div class="mt-1 text-sm text-slate-500">Total input survei bulan berjalan</div>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-6">
            <div class="text-xs text-slate-500 uppercase tracking-wider">Rata-rata IKM</div>
            <div class="mt-2 text-3xl font-extrabold text-[#0B5394]">{{ number_format($ikm, 2, ',', '.') }}</div>
            <div class="mt-1 text-sm text-slate-500">Skala IKM (1–100)</div>
        </div>
    </section>

    {{-- TABLE --}}
    <section id="latest" class="mt-6 rounded-2xl bg-white border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 flex items-center justify-between">
            <div>
                <div class="text-lg font-bold">Respon Terbaru</div>
                <div class="text-sm text-slate-500">10 respon terakhir khusus OPD Anda</div>
            </div>
            <div class="text-sm text-slate-500">Total: <span class="font-semibold text-slate-700">{{ $totalResponden }}</span></div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-y border-slate-200">
                <tr class="text-left text-slate-600">
                    <th class="px-6 py-3 font-semibold">Waktu</th>
                    <th class="px-6 py-3 font-semibold">Nama</th>
                    <th class="px-6 py-3 font-semibold">WA</th>
                    <th class="px-6 py-3 font-semibold">Gender</th>
                    <th class="px-6 py-3 font-semibold">Usia</th>
                    <th class="px-6 py-3 font-semibold">IKM</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse($latest as $r)
                    @php
                        $avg = (($r->u1+$r->u2+$r->u3+$r->u4+$r->u5+$r->u6+$r->u7+$r->u8+$r->u9) / 9);
                        $ikmRow = round($avg * 25, 2);
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3 text-slate-600">{{ $r->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-3 font-semibold text-slate-900">{{ $r->nama ?? '-' }}</td>
                        <td class="px-6 py-3 text-slate-700">{{ $r->no_wa ?? '-' }}</td>
                        <td class="px-6 py-3 text-slate-700">{{ $r->gender ?? '-' }}</td>
                        <td class="px-6 py-3 text-slate-700">{{ $r->usia ?? '-' }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#0B5394]/10 text-[#0B5394] font-semibold">
                                {{ number_format($ikmRow, 2, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                            Belum ada data respon untuk OPD ini.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection