@extends('layouts.admin')

@section('title', 'Data OPD & Layanan')
@section('page_title', 'Data OPD & Layanan')
@section('page_subtitle', 'Kelola daftar OPD (Dinas, RSUD, Kecamatan) dan layanan yang tersedia')

@section('content')
@php $brand = '#0B5394'; @endphp

<div class="space-y-6">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header + Search --}}
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Manajemen OPD & Layanan</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Tambah OPD (Dinas, RSUD, Kecamatan) dan layanan, edit cepat, dan hapus data.
                </p>
            </div>

            <form method="GET" class="flex items-center gap-2">
                <input name="q" value="{{ $q ?? '' }}"
                       class="h-11 w-64 rounded-2xl border border-slate-200 px-4 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30"
                       placeholder="Cari OPD / kode / layanan...">
                <button class="h-11 px-4 rounded-2xl text-sm font-semibold text-white shadow-sm hover:opacity-95"
                        style="background:{{ $brand }};">
                    Cari
                </button>
            </form>
        </div>
    </div>

    {{-- Form tambah OPD + tambah layanan --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <h3 class="font-semibold text-slate-900">Tambah OPD</h3>
            <form method="POST" action="{{ route('admin.dinas.store') }}" class="mt-4 space-y-3">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="text-xs text-slate-500">Kode</label>
                        <input name="kode" value="{{ old('kode') }}"
                            class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30"
                            placeholder="mis: dukcapil">
                        @error('kode') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-xs text-slate-500">Nama OPD</label>
                        <input name="nama" value="{{ old('nama') }}"
                            class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30"
                            placeholder="Nama OPD...">
                        @error('nama') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="text-xs text-slate-500">Category ID (opsional)</label>
                    <input type="number" name="category_id" value="{{ old('category_id') }}"
                        class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30"
                        placeholder="1 = Dinas, 2 = RSUD, 3 = Kecamatan">
                    @error('category_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <button class="h-11 px-5 rounded-2xl text-sm font-semibold text-white shadow-sm hover:opacity-95"
                        style="background:{{ $brand }};">
                    + Simpan OPD
                </button>
            </form>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <h3 class="font-semibold text-slate-900">Tambah Layanan</h3>
            <form method="POST" action="{{ route('admin.layanan.store') }}" class="mt-4 space-y-3">
                @csrf

                <div>
                    <label class="text-xs text-slate-500">Pilih OPD</label>
                    <select name="opd_id"
                            class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm bg-white outline-none focus:ring-2 focus:ring-[#0B5394]/30">
                        <option value="">-- pilih OPD --</option>

                        @foreach($allDinas as $d)
                            <option value="{{ $d->id }}" @selected(old('opd_id') == $d->id)>
                                {{ $d->nama }} ({{ $d->kode }})
                            </option>
                        @endforeach
                    </select>

                    @error('opd_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-xs text-slate-500">Nama Layanan</label>
                    <input name="nama" value="{{ old('nama') }}"
                        class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30"
                        placeholder="mis: Pembuatan KTP...">
                    @error('nama') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <button class="h-11 px-5 rounded-2xl text-sm font-semibold text-white shadow-sm hover:opacity-95"
                        style="background:{{ $brand }};">
                    + Simpan Layanan
                </button>
            </form>
        </div>
    </div>

    {{-- List OPD + layanan --}}
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-center justify-between gap-3">
            <h3 class="font-semibold text-slate-900">Daftar OPD & Layanan</h3>
            <div class="text-xs text-slate-500">
                Total: {{ $dinas->total() }} OPD
            </div>
        </div>

        <div class="mt-4 space-y-4">
            @forelse($dinas as $d)
                <div class="rounded-3xl border border-slate-200 overflow-hidden">
                    {{-- Header OPD --}}
                    <div class="bg-slate-50 px-5 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <p class="font-semibold text-slate-900">
                                {{ $d->nama }}
                                <span class="text-xs text-slate-500 font-normal">({{ $d->kode }})</span>
                            </p>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Category ID: {{ $d->category_id ?? '-' }} • Layanan: {{ $d->services->count() }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            {{-- Edit OPD --}}
                            <form method="POST" action="{{ route('admin.dinas.update', $d->id) }}" class="flex gap-2">
                                @csrf
                                @method('PUT')
                                <input name="nama" value="{{ $d->nama }}" class="rounded-2xl border px-3 py-2 text-sm">
                                <button class="h-10 px-4 rounded-2xl text-sm font-semibold text-white"
                                        style="background:{{ $brand }};">Simpan</button>
                            </form>

                            {{-- Hapus OPD --}}
                            <form method="POST" action="{{ route('admin.dinas.destroy', $d->id) }}"
                                onsubmit="return confirm('Hapus OPD ini beserta seluruh layanannya?')">
                                @csrf
                                @method('DELETE')
                                <button class="h-10 px-4 rounded-2xl border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 text-sm font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Layanan milik OPD ini --}}
                    <div class="px-5 py-4">
                        @if($d->services->isEmpty())
                            <p class="text-sm text-slate-500">Belum ada layanan.</p>
                        @else
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-200">
                                        <th class="py-2 text-left font-medium">Nama Layanan</th>
                                        <th class="py-2 text-right font-medium">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($d->services as $s)
                                        <tr class="border-b border-slate-100">
                                            <td class="py-3 pr-3">{{ $s->nama }}</td>
                                            <td class="py-3 text-right">
                                                <div class="inline-flex items-center gap-2">
                                                    {{-- Edit Layanan --}}
                                                    <form method="POST" action="{{ route('admin.layanan.update', $s->id) }}" class="flex gap-2">
                                                        @csrf
                                                        @method('PUT')
                                                        <input name="nama" value="{{ $s->nama }}" class="rounded-2xl border px-3 py-2 text-sm">
                                                        <button class="h-9 px-3 rounded-2xl text-sm font-semibold text-white"
                                                                style="background:{{ $brand }};">Simpan</button>
                                                    </form>

                                                    {{-- Hapus Layanan --}}
                                                    <form method="POST" action="{{ route('admin.layanan.destroy', $s->id) }}"
                                                        onsubmit="return confirm('Hapus layanan ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="h-9 px-3 rounded-2xl border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 text-xs font-semibold">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 p-8 text-center">
                    <p class="text-sm text-slate-600">Belum ada data OPD.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6 flex justify-end items-center gap-2">
            {{-- Tombol Previous --}}
            @if ($dinas->onFirstPage())
                <span class="px-3 py-1 border rounded text-slate-400">&lt;</span>
            @else
                <a href="{{ $dinas->previousPageUrl() }}" class="px-3 py-1 border rounded hover:bg-slate-100">&lt;</a>
            @endif

            {{-- Nomor halaman aktif --}}
            <span class="px-3 py-1 border rounded bg-slate-200 font-semibold">
                {{ $dinas->currentPage() }}
            </span>

            {{-- Tombol Next --}}
            @if ($dinas->hasMorePages())
                <a href="{{ $dinas->nextPageUrl() }}" class="px-3 py-1 border rounded hover:bg-slate-100">&gt;</a>
            @else
                <span class="px-3 py-1 border rounded text-slate-400">&gt;</span>
            @endif
        </div>
    @endsection