<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekap IKM</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2 { margin: 0; padding: 6px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h1>Laporan Rekap Indeks Kepuasan Masyarakat</h1>
    <p>Data rekap rata-rata nilai IKM per OPD</p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>OPD</th>
                <th>Jumlah Responden</th>
                <th>Rata-rata IKM</th>
                <th>Kategori Mutu</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($rekap as $row)
                @php
                    $ikm = $row->rata_ikm;
                    if ($ikm >= 88.31) $kategori = 'A (Sangat Baik)';
                    elseif ($ikm >= 76.61) $kategori = 'B (Baik)';
                    elseif ($ikm >= 65.00) $kategori = 'C (Kurang Baik)';
                    else $kategori = 'D (Tidak Baik)';
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->opd_nama }}</td>
                    <td>{{ $row->jumlah_responden }}</td>
                    <td>{{ number_format($ikm, 2, ',', '.') }}</td>
                    <td>{{ $kategori }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top:20px; font-size:11px;">
        Sumber: Hasil Pengolahan dan Analisis Data, Tahun {{ date('Y') }}
    </p>
</body>
</html>