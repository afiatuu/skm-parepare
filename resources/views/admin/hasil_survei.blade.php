@extends('layouts.admin')

@section('title', 'Hasil Survei')
@section('page_title', 'Hasil Survei')
@section('page_subtitle', 'Lihat data responden dan ringkasan hasil')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-900">Data Hasil Survei</h2>
            <p class="mt-1 text-sm text-slate-500">
                Halaman ini menampilkan tabel <b>survey_responses</b> dengan filter OPD dan tanggal.
            </p>
        </div>
        <a href="{{ route('admin.hasil_survei.export', request()->query()) }}"
           class="h-11 inline-flex items-center justify-center px-5 rounded-2xl text-sm font-semibold text-white shadow-sm hover:opacity-95"
           style="background:#0B5394;">
            Export (CSV)
        </a>
    </div>

    {{-- FILTER TANGGAL --}}
    <form method="GET" action="{{ route('admin.hasil_survei') }}" class="mt-6 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Awal</label>
            <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                   class="rounded-xl border-slate-300 text-sm" />
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                   class="rounded-xl border-slate-300 text-sm" />
        </div>
        <div>
            <button class="px-4 py-2.5 rounded-2xl bg-[#0B5394] text-white text-sm font-semibold hover:opacity-95">
                Terapkan
            </button>
        </div>
        @if(request()->has('tanggal_awal') || request()->has('tanggal_akhir'))
            <div>
                <a href="{{ route('admin.hasil_survei') }}" class="text-xs text-slate-500 underline">Reset filter</a>
            </div>
        @endif
    </form>

    {{-- TABLE --}}
    <div class="mt-6 overflow-x-auto rounded-2xl border border-slate-200">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
            <tr class="border-b border-slate-200">
                <th class="px-4 py-3 text-left font-medium">Waktu</th>
                <th class="px-4 py-3 text-left font-medium">Nama</th>
                <th class="px-4 py-3 text-left font-medium">OPD</th>
                <th class="px-4 py-3 text-left font-medium">Usia</th>
                <th class="px-4 py-3 text-left font-medium">IKM</th>
                <th class="px-4 py-3 text-right font-medium">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($data as $respon)
                <tr class="border-b border-slate-200">
                    <td class="px-4 py-4">{{ $respon->created_at->format('d M Y H:i') }}</td>
                    <td class="px-4 py-4">{{ $respon->nama }}</td>
                    <td class="px-4 py-4">{{ $respon->opd_nama }}</td>
                    <td class="px-4 py-4">{{ $respon->usia }}</td>
                    <td class="px-4 py-4">{{ number_format($respon->nilai_ikm, 2) }}</td>
                    <td class="px-4 py-4 text-right">
                        <a href="{{ route('admin.hasil_survei.detail', $respon->id) }}"
                           class="text-blue-600 hover:underline">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-4 text-slate-500 text-center">
                        Belum ada data survei untuk filter yang dipilih.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $data->links() }}
    </div>
</div>
@endsection