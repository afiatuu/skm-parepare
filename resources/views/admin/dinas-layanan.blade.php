@extends('layouts.admin')
{{-- resources/views/admin/dinas-layanan.blade.php --}}

@section('title', 'Data OPD & Layanan')
@section('page_title', 'Data OPD & Layanan')
@section('page_subtitle', 'Kelola daftar OPD (Dinas, RSUD, Kecamatan) dan layanan yang tersedia')

@section('content')
@php $brand = '#0B5394'; @endphp

<div x-data="ajaxPagination" x-init="init()">
    <div class="space-y-6">

        {{-- Alert --}}
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
                        Tambah OPD dan layanan, edit cepat, dan hapus data.
                    </p>
                </div>

                <form method="GET" action="{{ route('admin.dinas_layanan') }}" class="flex items-center gap-2">
                    <input
                        name="q"
                        value="{{ $q ?? '' }}"
                        class="h-11 w-64 rounded-2xl border border-slate-200 px-4 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30"
                        placeholder="Cari OPD / kode / layanan...">
                    <button
                        type="submit"
                        class="h-11 px-4 rounded-2xl text-sm font-semibold text-white shadow-sm"
                        style="background:{{ $brand }};">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        {{-- Form Tambah OPD & Layanan --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            {{-- Tambah OPD --}}
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <h3 class="font-semibold text-slate-900">Tambah OPD</h3>

                {{-- PERBAIKAN: Route harus sesuai dengan yang ada di web.php --}}
                <form method="POST" action="{{ route('admin.dinas.store') }}" class="mt-4 space-y-3">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="text-xs text-slate-500">Kode OPD</label>
                            <input name="kode" value="{{ old('kode') }}"
                                class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm"
                                placeholder="mis: dukcapil">
                            @error('kode') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-xs text-slate-500">Nama OPD</label>
                            <input name="nama" value="{{ old('nama') }}"
                                class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm"
                                placeholder="Nama OPD...">
                            @error('nama') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-xs text-slate-500">Category ID (opsional)</label>
                        <input type="number" name="category_id" value="{{ old('category_id') }}"
                            class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm">
                    </div>

                    <button class="h-11 px-5 rounded-2xl text-sm font-semibold text-white"
                        style="background:{{ $brand }};">
                        + Simpan OPD
                    </button>
                </form>
            </div>

            {{-- Tambah Layanan --}}
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <h3 class="font-semibold text-slate-900">Tambah Layanan</h3>

                <form method="POST" action="{{ route('admin.layanan.store') }}" class="mt-4 space-y-3">
                    @csrf

                    <div>
                        <label class="text-xs text-slate-500">Pilih OPD</label>
                        <select name="kode_opd"
                            class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm">
                            <option value="">-- pilih OPD --</option>
                            @foreach($allOpds as $opd)
                                <option value="{{ $opd->kode }}" @selected(old('kode_opd') == $opd->kode)>
                                    {{ $opd->nama }} ({{ $opd->kode }})
                                </option>
                            @endforeach
                        </select>
                        @error('kode_opd') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-xs text-slate-500">Nama Layanan</label>
                        <input name="nama" value="{{ old('nama') }}"
                            class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm">
                        @error('nama') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button class="h-11 px-5 rounded-2xl text-sm font-semibold text-white"
                        style="background:{{ $brand }};">
                        + Simpan Layanan
                    </button>
                </form>
            </div>
        </div>

        {{-- List OPD --}}
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="font-semibold text-slate-900">Daftar OPD & Layanan</h3>
                <div class="text-xs text-slate-500" id="total-opd">
                    Total: {{ $opds->total() }} OPD
                </div>
            </div>

            <div id="dinas-list-container">
                {{-- PERBAIKAN: Kirimkan variabel dengan nama yang benar --}}
                @include('admin.partials.dinas-list', ['opds' => $opds, 'q' => $q])
            </div>
        </div>

    </div>
</div>
@endsection