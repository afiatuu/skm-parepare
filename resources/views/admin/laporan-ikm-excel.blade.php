<table>
    <thead>
        <tr>
            <th>OPD</th>
            <th>Jumlah Responden</th>
            <th>Rata-rata IKM</th>
            <th>Kategori</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rekap as $row)
            @php
                $ikm = $row->rata_ikm;
                if ($ikm >= 88.31) $kategori = 'A (Sangat Baik)';
                elseif ($ikm >= 76.61) $kategori = 'B (Baik)';
                elseif ($ikm >= 65.00) $kategori = 'C (Kurang Baik)';
                else $kategori = 'D (Tidak Baik)';
            @endphp
            <tr>
                <td>{{ $row->opd_nama }}</td>
                <td>{{ $row->jumlah_responden }}</td>
                <td>{{ number_format($ikm, 2) }}</td>
                <td>{{ $kategori }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Belum ada data survei untuk periode ini.</td>
            </tr>
        @endforelse
    </tbody>
</table>