@extends('layouts.admin')

@section('title', 'Detail Laporan IKM - ' . ($opdNama ?? ''))

@section('content')
<div class="container mx-auto">
    <h1 class="text-xl md:text-2xl font-bold mb-4">Detail Laporan IKM - {{ $opdNama }}</h1>

    {{-- Status --}}
    @if($laporan)
        @php
            $statusColor = [
                'draft' => 'bg-slate-400',
                'waiting_approval' => 'bg-blue-400',
                'approved' => 'bg-green-500',
                'published' => 'bg-indigo-500',
            ];
        @endphp
        <div class="mb-3">
            <strong>Status:</strong>
            <span class="inline-block px-3 py-1 rounded-full text-white text-xs font-semibold {{ $statusColor[$laporan->status] ?? 'bg-slate-400' }}">
                {{ ucfirst(str_replace('_', ' ', $laporan->status)) }}
            </span>
        </div>
    @endif

    {{-- Distribusi Responden Pelayanan Publik --}}
    <h4 class="font-semibold mb-2">Distribusi Responden Pelayanan Publik</h4>
    @php
        $totalResponden = $responden->count();
    @endphp

    <table class="w-full border border-slate-400 border-collapse rounded-md text-sm mb-6 shadow-md">
        <thead class="bg-slate-700 text-white font-semibold">
            <tr>
                <th class="px-4 py-2 border border-slate-400">Karakteristik</th>
                <th class="px-4 py-2 border border-slate-400">Frekuensi</th>
                <th class="px-4 py-2 border border-slate-400">Persentase</th>
            </tr>
        </thead>
        <tbody>
            {{-- Jenis Kelamin --}}
            <tr class="bg-slate-200 font-semibold">
                <td colspan="3" class="px-4 py-2 border border-slate-300 text-center">Jenis Kelamin</td>
            </tr>
            @foreach($gender as $g => $count)
                <tr class="odd:bg-white even:bg-slate-50">
                    <td class="px-4 py-2 border border-slate-300">{{ $g }}</td>
                    <td class="px-4 py-2 border border-slate-300">{{ $count }}</td>
                    <td class="px-4 py-2 border border-slate-300">
                        {{ $totalResponden > 0 ? number_format(($count / $totalResponden) * 100, 2, ',', '.') : '0,00' }}
                    </td>
                </tr>
            @endforeach
            <tr class="bg-slate-100 font-semibold">
                <td class="px-4 py-2 border border-slate-300">Total</td>
                <td class="px-4 py-2 border border-slate-300">{{ $totalResponden }}</td>
                <td class="px-4 py-2 border border-slate-300">100</td>
            </tr>

            {{-- Kelompok Umur --}}
            <tr class="bg-slate-200 font-semibold">
                <td colspan="3" class="px-4 py-2 border border-slate-300 text-center">Kelompok Umur</td>
            </tr>
            @foreach($usia as $u => $count)
                <tr class="odd:bg-white even:bg-slate-50">
                    <td class="px-4 py-2 border border-slate-300">{{ $u }}</td>
                    <td class="px-4 py-2 border border-slate-300">{{ $count }}</td>
                    <td class="px-4 py-2 border border-slate-300">
                        {{ $totalResponden > 0 ? number_format(($count / $totalResponden) * 100, 2, ',', '.') : '0,00' }}
                    </td>
                </tr>
            @endforeach
            <tr class="bg-slate-100 font-semibold">
                <td class="px-4 py-2 border border-slate-300">Total</td>
                <td class="px-4 py-2 border border-slate-300">{{ $totalResponden }}</td>
                <td class="px-4 py-2 border border-slate-300">100</td>
            </tr>

            {{-- Tingkat Pendidikan --}}
            <tr class="bg-slate-200 font-semibold">
                <td colspan="3" class="px-4 py-2 border border-slate-300 text-center">Tingkat Pendidikan</td>
            </tr>
            @foreach($pendidikan as $p => $count)
                <tr class="odd:bg-white even:bg-slate-50">
                    <td class="px-4 py-2 border border-slate-300">{{ $p }}</td>
                    <td class="px-4 py-2 border border-slate-300">{{ $count }}</td>
                    <td class="px-4 py-2 border border-slate-300">
                        {{ $totalResponden > 0 ? number_format(($count / $totalResponden) * 100, 2, ',', '.') : '0,00' }}
                    </td>
                </tr>
            @endforeach
            <tr class="bg-slate-100 font-semibold">
                <td class="px-4 py-2 border border-slate-300">Total</td>
                <td class="px-4 py-2 border border-slate-300">{{ $totalResponden }}</td>
                <td class="px-4 py-2 border border-slate-300">100</td>
            </tr>

            {{-- Pekerjaan --}}
            <tr class="bg-slate-200 font-semibold">
                <td colspan="3" class="px-4 py-2 border border-slate-300 text-center">Pekerjaan</td>
            </tr>
            @foreach($pekerjaan as $pk => $count)
                <tr class="odd:bg-white even:bg-slate-50">
                    <td class="px-4 py-2 border border-slate-300">{{ $pk }}</td>
                    <td class="px-4 py-2 border border-slate-300">{{ $count }}</td>
                    <td class="px-4 py-2 border border-slate-300">
                        {{ $totalResponden > 0 ? number_format(($count / $totalResponden) * 100, 2, ',', '.') : '0,00' }}
                    </td>
                </tr>
            @endforeach
            <tr class="bg-slate-100 font-semibold">
                <td class="px-4 py-2 border border-slate-300">Total</td>
                <td class="px-4 py-2 border border-slate-300">{{ $totalResponden }}</td>
                <td class="px-4 py-2 border border-slate-300">100</td>
            </tr>
        </tbody>
    </table>

    {{-- Tabel unsur SKM --}}
    <h4 class="font-semibold mb-2">Nilai Rata-Rata (NRR) Unsur Pelayanan Publik</h4>
    @php
        $labelUnsur = [
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
    @endphp
    <table class="w-full border border-slate-400 border-collapse rounded-md text-sm mb-6 shadow-md">
        <thead class="bg-slate-700 text-white font-semibold">
            <tr>
                <th class="px-4 py-2 border border-slate-400">No.</th>
                <th class="px-4 py-2 border border-slate-400">Unsur SKM</th>
                <th class="px-4 py-2 border border-slate-400">NRR per Unsur</th>
                <th class="px-4 py-2 border border-slate-400">NRR Tertimbang</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($labelUnsur as $key => $label)
                @php
                    $nrr = $avgUnsur[$key] ?? 0;
                    $tertimbang = $nrr / 9;
                @endphp
                <tr class="odd:bg-white even:bg-slate-50">
                    <td class="px-4 py-2 border border-slate-300">{{ $no++ }}</td>
                    <td class="px-4 py-2 border border-slate-300">{{ $label }}</td>
                    <td class="px-4 py-2 border border-slate-300">{{ number_format($nrr, 2, ',', '.') }}</td>
                    <td class="px-4 py-2 border border-slate-300">{{ number_format($tertimbang, 2, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- Ringkasan Indeks & SKM di kolom NRR Tertimbang --}}
            <tr class="bg-slate-100 font-semibold text-center">
                <td colspan="3" class="px-4 py-2 border border-slate-300">Nilai Indeks</td>
                <td class="px-4 py-2 border border-slate-300">{{ number_format($nilaiIndeks, 2, ',', '.') }}</td>
            </tr>
            <tr class="bg-slate-100 font-semibold text-center">
                <td colspan="3" class="px-4 py-2 border border-slate-300">Nilai SKM Setelah Dikonversi (NI x 25)</td>
                <td class="px-4 py-2 border border-slate-300">{{ number_format($ikm, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    
    {{-- Indeks Kepuasan Masyarakat --}}
    <h4 class="font-semibold mb-2">Indeks Kepuasan Masyarakat</h4>
    <table class="w-full border border-slate-400 border-collapse rounded-md text-sm mb-6 shadow-md">
        <thead class="bg-slate-700 text-white font-semibold">
            <tr>
                <th class="px-4 py-2 border border-slate-400">Bidang Pelayanan</th>
                <th class="px-4 py-2 border border-slate-400">Nilai Indeks</th>
                <th class="px-4 py-2 border border-slate-400">Nilai IKM</th>
                <th class="px-4 py-2 border border-slate-400">Mutu Pelayanan</th>
                <th class="px-4 py-2 border border-slate-400">Kepuasan Masyarakat</th>
            </tr>
        </thead>
        <tbody>
            <tr class="odd:bg-white even:bg-slate-50">
                <td class="px-4 py-2 border border-slate-300">{{ $opdNama }}</td>
                <td class="px-4 py-2 border border-slate-300 text-center">{{ number_format($nilaiIndeks, 2, ',', '.') }}</td>
                <td class="px-4 py-2 border border-slate-300 text-center">{{ number_format($ikm, 2, ',', '.') }}</td>
                <td class="px-4 py-2 border border-slate-300 text-center">{{ $mutu }}</td>
                <td class="px-4 py-2 border border-slate-300 text-center">{{ $kepuasan }}</td>
            </tr>
        </tbody>
    </table>
    {{-- Tombol aksi --}}
    <div class="mt-6 flex gap-2">
        @if($laporan)
            <a href="{{ route('admin.laporan_ikm.exportDetailPdf', $laporan->opd_kode) }}"
            class="h-10 px-4 rounded-md text-white bg-red-600 hover:bg-red-700 text-sm font-semibold flex items-center justify-center">
                Export PDF
            </a>
            <a href="{{ route('admin.laporan_ikm.exportDetailExcel', $laporan->opd_kode) }}"
            class="h-10 px-4 rounded-md text-white bg-green-600 hover:bg-green-700 text-sm font-semibold flex items-center justify-center">
                Export Excel
            </a>
            <form action="{{ route('admin.laporan_ikm.kirim', $laporan->id) }}" method="POST">
                @csrf
                <button type="submit"
                        class="h-10 px-4 rounded-md text-white bg-blue-600 hover:bg-blue-700 text-sm font-semibold flex items-center justify-center">
                    Kirim ke Kepala
                </button>
            </form>

            {{-- Tombol publikasi muncul hanya jika status approved --}}
            @if($laporan->status === 'approved')
                <form action="{{ route('admin.laporan_ikm.publish', $laporan->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="h-10 px-4 rounded-md text-white bg-indigo-600 hover:bg-indigo-700 text-sm font-semibold flex items-center justify-center">
                        Publikasikan
                    </button>
                </form>
            @endif
        @endif

        <a href="{{ route('admin.laporan_ikm') }}"
        class="h-10 px-4 rounded-md text-slate-700 bg-slate-200 hover:bg-slate-300 text-sm font-semibold flex items-center justify-center">
            Kembali
        </a>
    </div>

</div>
@endsection