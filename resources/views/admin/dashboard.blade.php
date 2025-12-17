{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard E-SKM Kota Parepare')
@section('page_subtitle', 'Ringkasan survei, responden, dan nilai IKM')

@section('content')
@php
    $brand = '#0B5394';
@endphp

<div class="space-y-6">

    {{-- HERO --}}
    <section class="relative overflow-hidden rounded-3xl border border-slate-200 shadow-sm">
        <div class="absolute inset-0"
             style="background: linear-gradient(90deg, {{ $brand }} 0%, #0E7BC7 55%, #13B6D1 100%);"></div>

        {{-- dekorasi halus --}}
        <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full bg-white/10 blur-2xl"></div>
        <div class="absolute -bottom-24 -right-24 h-72 w-72 rounded-full bg-white/10 blur-2xl"></div>

        <div class="relative p-7 md:p-10 text-white">
            <p class="text-[11px] md:text-xs uppercase tracking-[0.25em] text-white/90">
                E-SURVEY KEPUASAN MASYARAKAT
            </p>

            <h2 class="mt-3 text-2xl md:text-4xl font-bold leading-tight">
                Selamat datang, {{ auth()->user()->name }} 👋
            </h2>

            <p class="mt-3 max-w-3xl text-white/90 text-sm md:text-base leading-relaxed">
                Kelola survei kepuasan masyarakat Kota Parepare. Pantau responden, nilai IKM, dan performa unit layanan.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('survey.opd.select') }}"
                   class="h-11 inline-flex items-center justify-center px-5 rounded-2xl bg-white/15 hover:bg-white/20 border border-white/25 text-sm font-semibold">
                    Buka Halaman Survei
                </a>
            </div>
        </div>
    </section>

    {{-- KPI --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <p class="text-[11px] text-slate-500 uppercase tracking-wider">Responden Hari Ini</p>
            <p class="mt-2 text-4xl font-bold text-slate-900">{{ $respondenHariIni }}</p>
            <p class="mt-1 text-xs text-slate-500">Total input survei hari ini</p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <p class="text-[11px] text-slate-500 uppercase tracking-wider">Responden Bulan Ini</p>
            <p class="mt-2 text-4xl font-bold text-slate-900">{{ $respondenBulanIni }}</p>
            <p class="mt-1 text-xs text-slate-500">Total input survei bulan berjalan</p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <p class="text-[11px] text-slate-500 uppercase tracking-wider">Rata-rata IKM</p>
            <p class="mt-2 text-4xl font-bold text-slate-900">{{ number_format($avgIkm, 2, ',', '.') }}</p>
            <p class="mt-1 text-xs text-slate-500">Skala IKM (1–100)</p>
        </div>
    </section>

</div>
@endsection