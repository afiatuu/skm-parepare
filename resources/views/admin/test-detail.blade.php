@extends('layouts.admin')

@section('title', 'Detail Laporan IKM - ' . $opdKode)

@section('content')
<section class="mb-6">
    <h1 class="text-xl md:text-2xl font-bold text-slate-900">Detail Laporan IKM</h1>
    <p class="text-sm text-slate-500 mt-1">OPD: <span class="font-semibold">{{ $opdNama }}</span></p>
</section>

{{-- Distribusi Responden --}}
<section class="rounded-2xl bg-white border border-slate-200 p-6 mb-8">
    <h2 class="text-base font-semibold text-slate-900 mb-4">Distribusi Responden</h2>
    <table class="min-w-full text-sm border border-slate-300">
        <thead class="bg-slate-50">
            <tr class="text-left text-slate-600">
                <th class="px-4 py-2 border">Karakteristik</th>
                <th class="px-4 py-2 border">Frekuensi</th>
                <th class="px-4 py-2 border">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = $responden->count();
            @endphp
            {{-- Jenis Kelamin --}}
            <tr><td class="px-4 py-2 border font-semibold">Jenis Kelamin</td><td class="px-4 py-2 border"></td><td class="px-4 py-2 border"></td></tr>
            @foreach($gender as $key => $val)
                <tr>
                    <td class="px-4 py-2 border">{{ $key }}</td>
                    <td class="px-4 py-2 border">{{ $val }}</td>
                    <td class="px-4 py-2 border">{{ number_format(($val/$total)*100, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr><td class="px-4 py-2 border font-semibold">Total</td><td class="px-4 py-2 border">{{ $total }}</td><td class="px-4 py-2 border">100</td></tr>

            {{-- Kelompok Umur --}}
            <tr><td class="px-4 py-2 border font-semibold">Kelompok Umur</td><td class="px-4 py-2 border"></td><td class="px-4 py-2 border"></td></tr>
            @foreach($usia as $key => $val)
                <tr>
                    <td class="px-4 py-2 border">{{ $key }}</td>
                    <td class="px-4 py-2 border">{{ $val }}</td>
                    <td class="px-4 py-2 border">{{ number_format(($val/$total)*100, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr><td class="px-4 py-2 border font-semibold">Total</td><td class="px-4 py-2 border">{{ $total }}</td><td class="px-4 py-2 border">100</td></tr>

            {{-- Pendidikan --}}
            <tr><td class="px-4 py-2 border font-semibold">Tingkat Pendidikan</td><td class="px-4 py-2 border"></td><td class="px-4 py-2 border"></td></tr>
            @foreach($pendidikan as $key => $val)
                <tr>
                    <td class="px-4 py-2 border">{{ $key }}</td>
                    <td class="px-4 py-2 border">{{ $val }}</td>
                    <td class="px-4 py-2 border">{{ number_format(($val/$total)*100, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr><td class="px-4 py-2 border font-semibold">Total</td><td class="px-4 py-2 border">{{ $total }}</td><td class="px-4 py-2 border">100</td></tr>

            {{-- Pekerjaan --}}
            <tr><td class="px-4 py-2 border font-semibold">Pekerjaan</td><td class="px-4 py-2 border"></td><td class="px-4 py-2 border"></td></tr>
            @foreach($pekerjaan as $key => $val)
                <tr>
                    <td class="px-4 py-2 border">{{ $key }}</td>
                    <td class="px-4 py-2 border">{{ $val }}</td>
                    <td class="px-4 py-2 border">{{ number_format(($val/$total)*100, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr><td class="px-4 py-2 border font-semibold">Total</td><td class="px-4 py-2 border">{{ $total }}</td><td class="px-4 py-2 border">100</td></tr>
        </tbody>
    </table>
</section>

{{-- Nilai Rata-rata Unsur Pelayanan --}}
<section class="rounded-2xl bg-white border border-slate-200 p-6 mb-8">
    <h2 class="text-base font-semibold text-slate-900 mb-4">Nilai Rata-Rata (NRR) Unsur Pelayanan Publik</h2>
    <table class="min-w-full text-sm border border-slate-300">
        <thead class="bg-slate-50">
            <tr class="text-left text-slate-600">
                <th class="px-4 py-2 border">No.</th>
                <th class="px-4 py-2 border">Unsur SKM</th>
                <th class="px-4 py-2 border">NRR per Unsur</th>
                <th class="px-4 py-2 border">NRR Tertimbang</th>
            </tr>
        </thead>
        <tbody>
            @php
                $unsurLabels = [
                    'u1' => 'Persyaratan',
                    'u2' => 'Sistem, Mekanisme, dan Prosedur',
                    'u3' => 'Waktu Penyelesaian',
                    'u4' => 'Biaya/Tarif',
                    'u5' => 'Produk Spesifikasi Jenis Pelayanan',
                    'u6' => 'Kompetensi Pelaksana',
                    'u7' => 'Perilaku Pelaksana',
                    'u8' => 'Penanganan Pengaduan, Saran, dan Masukan',
                    'u9' => 'Sarana dan Prasarana',
                ];
                $no = 1;
                $nilaiIndeks = collect($avgUnsur)->avg();
                $ikm = round($nilaiIndeks * 25, 2);
            @endphp
            @foreach($avgUnsur as $kode => $nilai)
                <tr>
                    <td class="px-4 py-2 border">{{ $no++ }}</td>
                    <td class="px-4 py-2 border">{{ $unsurLabels[$kode] ?? $kode }}</td>
                    <td class="px-4 py-2 border">{{ number_format($nilai, 2, ',', '.') }}</td>
                    <td class="px-4 py-2 border">{{ number_format($nilai/9, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="px-4 py-2 border font-semibold">Nilai Indeks</td>
                <td colspan="2" class="px-4 py-2 border">{{ number_format($nilaiIndeks, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2" class="px-4 py-2 border font-semibold">Nilai SKM Setelah Dikonversi (NI x 25)</td>
                <td colspan="2" class="px-4 py-2 border">{{ number_format($ikm, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</section>

{{-- Indeks Kepuasan Masyarakat --}}
<section class="rounded-2xl bg-white border border-slate-200 p-6 mb-8">
    <h2 class="text-base font-semibold text-slate-900 mb-4">Indeks Kepuasan Masyarakat</h2>
    <table class="min-w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr class="text-left text-slate-600">
                <th class="px-6 py-3 font-semibold">Bidang Pelayanan</th>
                <th class="px-6 py-3 font-semibold">Nilai Indeks</th>
                <th class="px-6 py-3 font-semibold">Nilai IKM</th>
                <th class="px-6 py-3 font-semibold">Mutu Pelayanan</th>
                <th class="px-6 py-3 font-semibold">Kepuasan Masyarakat</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <tr>
                <td class="px-6 py-3 font-semibold text-slate-900">{{ $opdNama }}</td>
                <td class="px-6 py-3 text-slate-700">{{ number_format($ikm/25, 2, ',', '.') }}</td>
                <td class="px-6 py-3 text-slate-700">{{ number_format($ikm, 2, ',', '.') }}</td>
                <td class="px-6 py-3 text-slate-700">{{ $mutu }}</td>
                <td class="px-6 py-3 text-slate-700">
                    {{ str_contains($mutu, 'A') || str_contains($mutu, 'B') ? 'Baik' : 'Tidak Baik' }}
                </td>
            </tr>
        </tbody>
    </table>
</section>

{{-- Tombol Export & Workflow --}}
<div class="flex gap-4 mt-6">
    {{-- Export PDF --}}
    <a href="{{ route('admin.laporan_ikm.exportDetailPdf', $opdKode) }}"
       class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
        Export PDF
    </a>

    {{-- Export Excel --}}
    <a href="{{ route('admin.laporan_ikm.exportDetailExcel', $opdKode) }}"
       class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
        Export Excel
    </a>

    {{-- Workflow laporan --}}
    @if ($laporan)
        <form action="{{ route('admin.laporan_ikm.kirim', $laporan->id) }}" method="POST">
            @csrf
            <button type="submit"
                class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                Kirim ke Kepala OPD
            </button>
        </form>
        <span class="ml-2 text-xs text-slate-500">Status: {{ $laporan->status }}</span>
    @else
        <form action="{{ route('admin.laporan_ikm.storeDraft', $opdKode) }}" method="POST">
            @csrf
            <button type="submit"
                class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                Buat Laporan
            </button>
        </form>
    @endif
</div>
@endsection