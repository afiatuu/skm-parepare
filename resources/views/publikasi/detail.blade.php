<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    @php
        // Fallback berurutan: relasi OPD -> kolom opd_nama -> opd_kode
        $opdNama = $laporan->opd->nama ?? $laporan->opd_nama ?? $laporan->opd_kode;
    @endphp
    <title>Detail Publikasi IKM – {{ $opdNama }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #111; max-width: 960px; margin: auto; padding: 24px; }
        h2, h3, h4 { margin: 12px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        thead { background-color: #374151; color: #fff; }
        th, td { border: 1px solid #444; padding: 6px; vertical-align: middle; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .section-title td { background-color: #e5e7eb; font-weight: bold; text-align: center; }
        .total-row td { background-color: #f3f4f6; font-weight: bold; }
        .text-center { text-align: center; }
        .btn-back { display: inline-block; padding: 8px 16px; background-color: #e5e7eb; color: #111; text-decoration: none; border-radius: 4px; font-weight: bold; }
        .btn-back:hover { background-color: #d1d5db; }
    </style>
</head>

    <h2 style="background-color:#f3f4f6; padding:12px; border-radius:6px; text-align:center;">
        Laporan Indeks Kepuasan Masyarakat
    </h2>
    <div class="subtitle"><strong>OPD:</strong> {{ $opdNama }}</div>

    {{-- Distribusi Responden --}}
    <h4 style="margin-top:24px;">Distribusi Responden Pelayanan Publik</h4>
    <table>
        <thead>
            <tr>
                <th>Karakteristik</th>
                <th>Frekuensi</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            {{-- Jenis Kelamin --}}
            <tr class="section-title"><td colspan="3">Jenis Kelamin</td></tr>
            @foreach($gender as $g => $count)
                <tr>
                    <td>{{ $g }}</td>
                    <td class="text-center">{{ $count }}</td>
                    <td class="text-center">{{ $responden->count() > 0 ? number_format(($count/$responden->count())*100, 2, ',', '.') : '0,00' }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td>Total</td>
                <td class="text-center">{{ $responden->count() }}</td>
                <td class="text-center">100</td>
            </tr>

            {{-- Kelompok Umur --}}
            <tr class="section-title"><td colspan="3">Kelompok Umur</td></tr>
            @foreach($usia as $u => $count)
                <tr>
                    <td>{{ $u }}</td>
                    <td class="text-center">{{ $count }}</td>
                    <td class="text-center">{{ $responden->count() > 0 ? number_format(($count/$responden->count())*100, 2, ',', '.') : '0,00' }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td>Total</td>
                <td class="text-center">{{ $responden->count() }}</td>
                <td class="text-center">100</td>
            </tr>

            {{-- Tingkat Pendidikan --}}
            <tr class="section-title"><td colspan="3">Tingkat Pendidikan</td></tr>
            @foreach($pendidikan as $p => $count)
                <tr>
                    <td>{{ $p }}</td>
                    <td class="text-center">{{ $count }}</td>
                    <td class="text-center">{{ $responden->count() > 0 ? number_format(($count/$responden->count())*100, 2, ',', '.') : '0,00' }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td>Total</td>
                <td class="text-center">{{ $responden->count() }}</td>
                <td class="text-center">100</td>
            </tr>

            {{-- Pekerjaan --}}
            <tr class="section-title"><td colspan="3">Pekerjaan</td></tr>
            @foreach($pekerjaan as $pk => $count)
                <tr>
                    <td>{{ $pk }}</td>
                    <td class="text-center">{{ $count }}</td>
                    <td class="text-center">{{ $responden->count() > 0 ? number_format(($count/$responden->count())*100, 2, ',', '.') : '0,00' }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td>Total</td>
                <td class="text-center">{{ $responden->count() }}</td>
                <td class="text-center">100</td>
            </tr>
        </tbody>
    </table>

    {{-- NRR Unsur --}}
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
        $urut = ['u1','u2','u3','u4','u5','u6','u7','u8','u9'];
    @endphp

    <h4 style="margin-top:24px;">Nilai Rata-Rata (NRR) Unsur Pelayanan Publik</h4>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Unsur SKM</th>
                <th>NRR per Unsur</th>
                <th>NRR Tertimbang</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($urut as $kode)
                @php
                    $nrr = $avgUnsur[$kode] ?? 0;
                    $tertimbang = $nrr / 9;
                @endphp
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $unsurLabels[$kode] }}</td>
                    <td class="text-center">{{ number_format($nrr, 2, ',', '.') }}</td>
                    <td class="text-center">{{ number_format($tertimbang, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" class="text-center">Nilai Indeks</td>
                <td class="text-center">{{ number_format($nilaiIndeks, 2, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3" class="text-center">Nilai SKM Setelah Dikonversi (NI x 25)</td>
                <td class="text-center">{{ number_format($ikm, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Indeks Kepuasan Masyarakat --}}
    <h4 style="margin-top:24px;">Indeks Kepuasan Masyarakat</h4>
    <table>
        <thead>
            <tr>
                <th>Bidang Pelayanan</th>
                <th>Nilai Indeks</th>
                <th>Nilai IKM</th>
                <th>Mutu Pelayanan</th>
                <th>Kepuasan Masyarakat</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $opdNama }}</td>
                <td class="text-center">{{ number_format($nilaiIndeks, 2, ',', '.') }}</td>
                <td class="text-center">{{ number_format($ikm, 2, ',', '.') }}</td>
                <td class="text-center">{{ $mutu }}</td>
                <td class="text-center">
                    @php
                        $kepuasan = 'Tidak Baik';
                        if ($ikm >=  88.31) $kepuasan = 'Sangat Baik';
                        elseif ($ikm >= 76.61) $kepuasan = 'Baik';
                        elseif ($ikm >= 65.00) $kepuasan = 'Kurang Baik';
                    @endphp
                    {{ $kepuasan }}
                </td>
            </tr>
        </tbody>
    </table>

</body>
</html>