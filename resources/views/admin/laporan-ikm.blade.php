@extends('layouts.admin')

@section('title', 'Laporan IKM')

@section('content')
    <section class="mb-6">
        <h1 class="text-xl md:text-2xl font-bold text-slate-900">Laporan IKM</h1>
        <p class="text-sm text-slate-500 mt-1">
            Rekap Indeks Kepuasan Masyarakat (IKM) per OPD berdasarkan responden yang sudah lengkap.
        </p>
    </section>

    {{-- Rekap OPD --}}
    @isset($rekap)
        <section class="rounded-2xl bg-white border border-slate-200 p-6">
            <h3 class="text-base font-semibold text-slate-900 mb-4">Rekap OPD</h3>

            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-600">
                        <th class="px-6 py-3 font-semibold">OPD</th>
                        <th class="px-6 py-3 font-semibold">Jumlah Responden</th>
                        <th class="px-6 py-3 font-semibold">Rata-rata IKM</th>
                        <th class="px-6 py-3 font-semibold">Kategori</th>
                        <th class="px-6 py-3 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekap as $row)
                        @php
                            $ikm = round($row->rata_ikm, 2);
                            $kategori = $ikm >= 88.31 ? 'A (Sangat Baik)'
                                        : ($ikm >= 76.61 ? 'B (Baik)'
                                        : ($ikm >= 65.00 ? 'C (Kurang Baik)' : 'D (Tidak Baik)'));
                        @endphp
                        <tr class="border-t border-slate-200">
                            <td class="px-6 py-3">{{ $row->opd_nama }}</td>
                            <td class="px-6 py-3">{{ $row->jumlah_responden }}</td>
                            <td class="px-6 py-3">{{ number_format($ikm, 2, ',', '.') }}</td>
                            <td class="px-6 py-3">{{ $kategori }}</td>
                            <td class="px-6 py-3">
                                <a href="{{ route('admin.laporan_ikm.detail', $row->opd_kode) }}"
                                   class="px-3 py-1 rounded-md text-white bg-indigo-600 hover:bg-indigo-700 text-xs font-semibold">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-center text-slate-500">Belum ada data rekap.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    @endisset
@endsection