@extends('layouts.kepala')

@section('title', 'Dashboard Kepala OPD - E-SKM')
@section('page_title', 'Dashboard Kepala OPD')
@section('page_desc', 'Pantau ringkasan IKM dan masukan responden untuk OPD Anda')

@section('content')
    {{-- HERO --}}
    <section class="rounded-[22px] bg-gradient-to-r from-[#0B5394] to-[#1CC7D0] text-white p-6 md:p-8 shadow-sm border border-white/10">
        <div class="text-xs uppercase tracking-wider opacity-90">E-SURVEY KEPUASAN MASYARAKAT</div>
        <div class="mt-2 text-2xl md:text-3xl font-extrabold">
            Selamat datang, {{ $user->name }} 👋
        </div>
        <p class="mt-2 text-sm md:text-base opacity-95">
            Anda login sebagai <b>Kepala OPD</b>. OPD: <b>{{ $opdKode }}</b>. Pantau performa layanan dan saran masyarakat di sini.
        </p>

        <div class="mt-5 flex flex-wrap gap-3">
            <a href="{{ route('home') }}"
               class="px-4 py-2.5 rounded-2xl bg-white text-[#0B5394] font-semibold text-sm hover:opacity-95">
                Buka Beranda Publik
            </a>
        </div>
    </section>

    {{-- KPI --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        <div class="rounded-2xl bg-white border border-slate-200 p-6">
            <div class="text-xs text-slate-500 uppercase tracking-wider">Responden Hari Ini</div>
            <div class="mt-2 text-3xl font-extrabold text-slate-900">{{ $respondenHariIni }}</div>
            <div class="mt-1 text-sm text-slate-500">Total input survei hari ini</div>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-6">
            <div class="text-xs text-slate-500 uppercase tracking-wider">Responden Bulan Ini</div>
            <div class="mt-2 text-3xl font-extrabold text-slate-900">{{ $respondenBulanIni }}</div>
            <div class="mt-1 text-sm text-slate-500">Total input bulan berjalan</div>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-6">
            <div class="text-xs text-slate-500 uppercase tracking-wider">Rata-Rata IKM</div>
            <div class="mt-2 text-3xl font-extrabold text-[#0B5394]">{{ number_format($ikm, 2, ',', '.') }}</div>
            <div class="mt-1 text-sm text-slate-500">Skala 1–100</div>
        </div>
    </section>

    {{-- UNSUR --}}
    <section class="rounded-2xl bg-white border border-slate-200 mt-6 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="font-semibold text-slate-900">Ringkasan Nilai per Unsur</div>
            <div class="text-sm text-slate-500">Nilai 1–4 dikonversi ke skala 25–100</div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-600">
                        <th class="px-6 py-3 font-semibold">Kode</th>
                        <th class="px-6 py-3 font-semibold">Unsur</th>
                        <th class="px-6 py-3 font-semibold">Rata-rata (1–4)</th>
                        <th class="px-6 py-3 font-semibold">IKM Unsur</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($unsurData as $u)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-3 font-semibold text-slate-900">{{ $u['kode'] }}</td>
                            <td class="px-6 py-3 text-slate-800">{{ $u['nama'] }}</td>
                            <td class="px-6 py-3 text-slate-700">{{ number_format($u['nilai'], 2, ',', '.') }}</td>
                            <td class="px-6 py-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#0B5394]/10 text-[#0B5394] font-semibold">
                                    {{ number_format($u['ikm'], 2, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- SARAN TERBARU --}}
    <section class="rounded-2xl bg-white border border-slate-200 mt-6">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="font-semibold text-slate-900">Saran Terbaru</div>
            <div class="text-sm text-slate-500">5 masukan terakhir dari responden</div>
        </div>

        <div class="p-6 space-y-4">
            @forelse($saranTerbaru as $s)
                <div class="rounded-2xl border border-slate-200 p-4 bg-slate-50">
                    <div class="flex items-center justify-between gap-3">
                        <div class="font-semibold text-slate-900">{{ $s->nama ?? 'Responden' }}</div>
                        <div class="text-xs text-slate-500">{{ $s->created_at?->format('d/m/Y H:i') }}</div>
                    </div>
                    <p class="mt-2 text-sm text-slate-700 whitespace-pre-line">{{ $s->saran }}</p>
                </div>
            @empty
                <div class="text-sm text-slate-500">Belum ada saran/keluhan yang masuk.</div>
            @endforelse
        </div>
    </section>

    {{-- LAPORAN IKM & PERSETUJUAN --}}
    <section class="rounded-2xl bg-white border border-slate-200 mt-6 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="font-semibold text-slate-900">Daftar Laporan IKM</div>
            <div class="text-sm text-slate-500">Klik tombol Setujui untuk menyetujui laporan</div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-600">
                        <th class="px-6 py-3 font-semibold">Judul</th>
                        <th class="px-6 py-3 font-semibold">Nilai IKM</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold">Persetujuan</th>
                        <th class="px-6 py-3 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($laporan as $lap)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-3">{{ $lap->judul }}</td>
                            <td class="px-6 py-3">{{ number_format($lap->nilai_ikm, 2, ',', '.') }}</td>
                            <td class="px-6 py-3">{{ ucfirst($lap->status) }}</td>
                            <td class="px-6 py-3">
                                @if($lap->approved_by_kepala)
                                    ✅ Disetujui ({{ $lap->approved_at }})
                                @else
                                    ❌ Belum Disetujui
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                @if(!$lap->approved_by_kepala)
                                    <form action="{{ route('kepala.approve', $lap->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 bg-green-600 text-white rounded hover:opacity-90">
                                            Setujui
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-slate-500 text-center">
                                Belum ada laporan yang bisa ditinjau.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
 @endsection   