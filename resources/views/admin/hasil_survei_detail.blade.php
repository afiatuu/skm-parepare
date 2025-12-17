@extends('layouts.admin')

@section('title', 'Detail Responden')
@section('page_title', 'Detail Responden')
@section('page_subtitle', 'Lihat jawaban lengkap dari responden')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-8">

    {{-- ✅ Data Responden --}}
    <h2 class="text-lg font-bold text-slate-900 mb-4">Data Responden</h2>
    <table class="table-auto w-full border border-slate-400 border-collapse text-sm mb-6">
        <tbody>
            <tr><td class="border px-4 py-2 font-semibold">Nama</td><td class="border px-4 py-2">{{ $respon->nama }}</td></tr>
            <tr><td class="border px-4 py-2 font-semibold">No WA</td><td class="border px-4 py-2">{{ $respon->no_wa }}</td></tr>
            <tr><td class="border px-4 py-2 font-semibold">Gender</td><td class="border px-4 py-2">{{ $respon->gender }}</td></tr>
            <tr><td class="border px-4 py-2 font-semibold">Usia</td><td class="border px-4 py-2">{{ $respon->usia }}</td></tr>
            <tr><td class="border px-4 py-2 font-semibold">Pendidikan</td><td class="border px-4 py-2">{{ $respon->pendidikan }}</td></tr>
            <tr><td class="border px-4 py-2 font-semibold">Pekerjaan</td><td class="border px-4 py-2">{{ $respon->pekerjaan }}</td></tr>
            <tr><td class="border px-4 py-2 font-semibold">Kecamatan</td><td class="border px-4 py-2">{{ $respon->kecamatan }}</td></tr>
            <tr><td class="border px-4 py-2 font-semibold">Kelurahan</td><td class="border px-4 py-2">{{ $respon->kelurahan }}</td></tr>
            <tr><td class="border px-4 py-2 font-semibold">OPD</td><td class="border px-4 py-2">{{ $respon->opd_nama }}</td></tr>
            <tr><td class="border px-4 py-2 font-semibold">Layanan</td><td class="border px-4 py-2">{{ $respon->layanan_nama }}</td></tr>
        </tbody>
    </table>

    {{-- ✅ Jawaban Unsur SKM --}}
    <h2 class="text-lg font-bold text-slate-900 mb-4">Jawaban Unsur SKM</h2>
    <table class="table-auto w-full border border-slate-400 border-collapse text-sm mb-6">
        <thead class="bg-slate-100">
            <tr>
                <th class="border px-4 py-2">Unsur</th>
                <th class="border px-4 py-2">Nilai</th>
            </tr>
        </thead>
        <tbody>
            <tr><td class="border px-4 py-2">Persyaratan</td><td class="border px-4 py-2">{{ $respon->u1 }}</td></tr>
            <tr><td class="border px-4 py-2">Prosedur</td><td class="border px-4 py-2">{{ $respon->u2 }}</td></tr>
            <tr><td class="border px-4 py-2">Waktu</td><td class="border px-4 py-2">{{ $respon->u3 }}</td></tr>
            <tr><td class="border px-4 py-2">Biaya</td><td class="border px-4 py-2">{{ $respon->u4 }}</td></tr>
            <tr><td class="border px-4 py-2">Produk Layanan</td><td class="border px-4 py-2">{{ $respon->u5 }}</td></tr>
            <tr><td class="border px-4 py-2">Kompetensi Petugas</td><td class="border px-4 py-2">{{ $respon->u6 }}</td></tr>
            <tr><td class="border px-4 py-2">Perilaku Petugas</td><td class="border px-4 py-2">{{ $respon->u7 }}</td></tr>
            <tr><td class="border px-4 py-2">Penanganan Pengaduan</td><td class="border px-4 py-2">{{ $respon->u8 }}</td></tr>
            <tr><td class="border px-4 py-2">Sarana & Prasarana</td><td class="border px-4 py-2">{{ $respon->u9 }}</td></tr>
        </tbody>
    </table>

    {{-- ✅ Ringkasan --}}
    <h2 class="text-lg font-bold text-slate-900 mb-4">Ringkasan</h2>
    <table class="table-auto w-full border border-slate-400 border-collapse text-sm mb-6">
        <tbody>
            <tr><td class="border px-4 py-2 font-semibold">Saran</td><td class="border px-4 py-2">{{ $respon->saran ?? '-' }}</td></tr>
            <tr><td class="border px-4 py-2 font-semibold">Nilai IKM</td><td class="border px-4 py-2">{{ number_format($respon->nilai_ikm, 2) }}</td></tr>
            <tr><td class="border px-4 py-2 font-semibold">Status</td><td class="border px-4 py-2">{{ $respon->completed ? 'Selesai' : 'Belum Selesai' }}</td></tr>
            <tr>
                <td class="border px-4 py-2 font-semibold">Persetujuan Kepala OPD</td>
                <td class="border px-4 py-2">
                    @if($respon->laporan && $respon->laporan->approved_at)
                        Disetujui pada {{ $respon->laporan->approved_at->format('d M Y H:i') }}
                    @else
                        Belum Disetujui
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <div class="mt-6">
        <a href="{{ route('admin.hasil_survei') }}"
           class="px-4 py-2 bg-slate-600 text-white rounded hover:opacity-90">Kembali</a>
    </div>
</div>
@endsection