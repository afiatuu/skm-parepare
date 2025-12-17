<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveyResponse;
use App\Models\LaporanIkm;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanIkmController extends Controller
{
    public function index()
    {
        // Rekap rata-rata NI per OPD dari SurveyResponse
        $rekap = SurveyResponse::selectRaw('opd_kode, opd_nama,
            (AVG((u1+u2+u3+u4+u5+u6+u7+u8+u9)/9)) as rata_ni,
            COUNT(*) as jumlah_responden')
            ->where('completed', true)
            ->groupBy('opd_kode', 'opd_nama')
            ->orderByDesc('rata_ni')
            ->get();

        foreach ($rekap as $row) {
            // Konversi NI ke NIK (Nilai IKM)
            $row->rata_ikm = round($row->rata_ni * 25, 2);

            // Mapping Mutu & Kepuasan
            if ($row->rata_ikm >= 88.31) {
                $row->mutu = 'A'; $row->kepuasan = 'Sangat Baik';
            } elseif ($row->rata_ikm >= 76.61) {
                $row->mutu = 'B'; $row->kepuasan = 'Baik';
            } elseif ($row->rata_ikm >= 65.00) {
                $row->mutu = 'C'; $row->kepuasan = 'Kurang Baik';
            } elseif ($row->rata_ikm >= 25.00) {
                $row->mutu = 'D'; $row->kepuasan = 'Tidak Baik';
            } else {
                $row->mutu = '-'; $row->kepuasan = '-';
            }

            // Tambahkan info laporan sesuai role
            if (Auth::user()->role == 'admin') {
                $laporan = LaporanIkm::where('opd_kode', $row->opd_kode)
                    ->latest()
                    ->first();
            } else {
                $laporan = LaporanIkm::where('opd_kode', $row->opd_kode)
                    ->where('created_by', Auth::id())
                    ->latest()
                    ->first();
            }

            $row->laporan_id = $laporan?->id;
            $row->laporan_status = $laporan?->status;
        }

        return view('admin.laporan-ikm', compact('rekap'));
    }

    // Halaman detail: distribusi responden, unsur, indeks IKM (tetap dari SurveyResponse)
    public function detailOpd($opdKode)
    {
        $responden = SurveyResponse::where('opd_kode', $opdKode)
            ->where('completed', true)
            ->get();

        // Distribusi responden
        $gender = $responden->groupBy('gender')->map->count();
        $usia = $responden->groupBy(function ($r) {
            $u = $r->usia;
            return $u < 12 ? 'Anak-anak <12' :
                ($u <= 25 ? 'Remaja (12-25)' :
                ($u <= 45 ? 'Dewasa (26-45)' :
                ($u <= 65 ? 'Lansia (46-65)' : 'Manula >65')));
        })->map->count();
        $pendidikan = $responden->groupBy('pendidikan')->map->count();
        $pekerjaan = $responden->groupBy('pekerjaan')->map->count();

        // Nilai rata-rata unsur
        $avgUnsur = [
            'u1' => $responden->avg('u1'),
            'u2' => $responden->avg('u2'),
            'u3' => $responden->avg('u3'),
            'u4' => $responden->avg('u4'),
            'u5' => $responden->avg('u5'),
            'u6' => $responden->avg('u6'),
            'u7' => $responden->avg('u7'),
            'u8' => $responden->avg('u8'),
            'u9' => $responden->avg('u9'),
        ];

        $nilaiIndeks = collect($avgUnsur)->avg();
        $ikm = round($nilaiIndeks * 25, 2);

        // Mutu pelayanan & kepuasan masyarakat
        if ($ikm >= 88.31) {
            $mutu = 'A'; $kepuasan = 'Sangat Baik';
        } elseif ($ikm >= 76.61) {
            $mutu = 'B'; $kepuasan = 'Baik';
        } elseif ($ikm >= 65.00) {
            $mutu = 'C'; $kepuasan = 'Kurang Baik';
        } elseif ($ikm >= 25.00) {
            $mutu = 'D'; $kepuasan = 'Tidak Baik';
        } else {
            $mutu = '-'; $kepuasan = '-';
        }

        $opdNama = optional($responden->first())->opd_nama ?? 'OPD';

        // Ambil laporan terbaru untuk OPD ini (multi-versi)
        $laporan = LaporanIkm::where('opd_kode', $opdKode)
            ->latest()
            ->first();

        return view('admin.laporan-detail', compact(
            'opdKode',
            'opdNama',
            'responden',
            'gender',
            'usia',
            'pendidikan',
            'pekerjaan',
            'avgUnsur',
            'nilaiIndeks',
            'ikm',
            'mutu',
            'kepuasan',
            'laporan'
        ));
    }

    // Export PDF (rekap dari SurveyResponse)
    public function exportPdf()
    {
        $rekap = SurveyResponse::selectRaw('opd_nama, AVG(nilai_ikm) as rata_ikm, COUNT(*) as jumlah_responden')
            ->where('completed', true)
            ->groupBy('opd_nama')
            ->orderByDesc('rata_ikm')
            ->get();

        $pdf = Pdf::loadView('admin.laporan-ikm-pdf', compact('rekap'));
        return $pdf->download('laporan_ikm.pdf');
    }

    // Export Excel (CSV) (rekap dari SurveyResponse)
    public function exportExcel()
    {
        $rekap = SurveyResponse::selectRaw('opd_nama, AVG(nilai_ikm) as rata_ikm, COUNT(*) as jumlah_responden')
            ->where('completed', true)
            ->groupBy('opd_nama')
            ->orderByDesc('rata_ikm')
            ->get();

        $csv = "OPD,Jumlah Responden,Rata-rata IKM,Kategori\n";

        foreach ($rekap as $row) {
            $ikm = $row->rata_ikm;
            if ($ikm >= 88.31) $kategori = 'A (Sangat Baik)';
            elseif ($ikm >= 76.61) $kategori = 'B (Baik)';
            elseif ($ikm >= 65.00) $kategori = 'C (Kurang Baik)';
            else $kategori = 'D (Tidak Baik)';

            $csv .= "{$row->opd_nama},{$row->jumlah_responden}," . number_format($ikm, 2) . ",{$kategori}\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=\"laporan_ikm.csv\"',
        ]);
    }

    public function exportDetailPdf($opdKode)
    {
        $responden = SurveyResponse::where('opd_kode', $opdKode)->where('completed', true)->get();
        $opdNama = $responden->first()->opd_nama ?? $opdKode;

        // Distribusi responden
        $gender = $responden->groupBy('gender')->map->count();
        $usia = $responden->groupBy(function ($r) {
            $u = $r->usia;
            return $u < 12 ? 'Anak-anak <12' :
                ($u <= 25 ? 'Remaja (12–25)' :
                ($u <= 45 ? 'Dewasa (26–45)' :
                ($u <= 65 ? 'Lansia (46–65)' : 'Manula >65')));
        })->map->count();
        $pendidikan = $responden->groupBy('pendidikan')->map->count();
        $pekerjaan = $responden->groupBy('pekerjaan')->map->count();

        // Unsur SKM
        $avgUnsur = [
            'u1' => $responden->avg('u1'),
            'u2' => $responden->avg('u2'),
            'u3' => $responden->avg('u3'),
            'u4' => $responden->avg('u4'),
            'u5' => $responden->avg('u5'),
            'u6' => $responden->avg('u6'),
            'u7' => $responden->avg('u7'),
            'u8' => $responden->avg('u8'),
            'u9' => $responden->avg('u9'),
        ];
        $nilaiIndeks = collect($avgUnsur)->avg();
        $ikm = round($nilaiIndeks * 25, 2);
        $mutu = $ikm >= 88.31 ? 'A (Sangat Baik)' :
                ($ikm >= 76.61 ? 'B (Baik)' :
                ($ikm >= 65.00 ? 'C (Kurang Baik)' : 'D (Tidak Baik)'));

        return Pdf::loadView('admin.detail-pdf', compact(
            'responden', 'opdNama', 'gender', 'usia', 'pendidikan', 'pekerjaan',
            'avgUnsur', 'nilaiIndeks', 'ikm', 'mutu'
        ))->download("laporan_ikm_{$opdKode}.pdf");
    }

    public function exportDetailExcel($opdKode)
    {
        $responden = SurveyResponse::where('opd_kode', $opdKode)->where('completed', true)->get();
        $opdNama = $responden->first()->opd_nama ?? $opdKode;
        $total = $responden->count();

        // Distribusi responden
        $gender = $responden->groupBy('gender')->map->count();
        $usia = $responden->groupBy(function ($r) {
            $u = $r->usia;
            return $u < 12 ? 'Anak-anak <12' :
                ($u <= 25 ? 'Remaja (12–25)' :
                ($u <= 45 ? 'Dewasa (26–45)' :
                ($u <= 65 ? 'Lansia (46–65)' : 'Manula >65')));
        })->map->count();
        $pendidikan = $responden->groupBy('pendidikan')->map->count();
        $pekerjaan = $responden->groupBy('pekerjaan')->map->count();

        // Unsur SKM
        $avgUnsur = [
            'u1' => $responden->avg('u1'),
            'u2' => $responden->avg('u2'),
            'u3' => $responden->avg('u3'),
            'u4' => $responden->avg('u4'),
            'u5' => $responden->avg('u5'),
            'u6' => $responden->avg('u6'),
            'u7' => $responden->avg('u7'),
            'u8' => $responden->avg('u8'),
            'u9' => $responden->avg('u9'),
        ];
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

        $nilaiIndeks = collect($avgUnsur)->avg();
        $ikm = round($nilaiIndeks * 25, 2);
        $mutu = $ikm >= 88.31 ? 'A' : ($ikm >= 76.61 ? 'B' : ($ikm >= 65.00 ? 'C' : 'D'));
        $kepuasan = $mutu === 'A' ? 'Sangat Baik' : ($mutu === 'B' ? 'Baik' : ($mutu === 'C' ? 'Kurang Baik' : 'Tidak Baik'));

        // Bangun CSV
        $csv = "Distribusi Responden\nKarakteristik,Frekuensi,Persentase\n";
        foreach ($gender as $key => $val) {
            $csv .= "$key,$val," . number_format(($val/$total)*100, 2) . "\n";
        }
        $csv .= "Total,$total,100\n\n";

        $csv .= "Kelompok Umur\nKarakteristik,Frekuensi,Persentase\n";
        foreach ($usia as $key => $val) {
            $csv .= "$key,$val," . number_format(($val/$total)*100, 2) . "\n";
        }
        $csv .= "Total,$total,100\n\n";

        $csv .= "Tingkat Pendidikan\nKarakteristik,Frekuensi,Persentase\n";
        foreach ($pendidikan as $key => $val) {
            $csv .= "$key,$val," . number_format(($val/$total)*100, 2) . "\n";
        }
        $csv .= "Total,$total,100\n\n";

        $csv .= "Pekerjaan\nKarakteristik,Frekuensi,Persentase\n";
        foreach ($pekerjaan as $key => $val) {
            $csv .= "$key,$val," . number_format(($val/$total)*100, 2) . "\n";
        }
        $csv .= "Total,$total,100\n\n";

        // NRR Unsur dengan nama unsur
        $csv .= "Nilai Rata-Rata Unsur Pelayanan\nNo,Unsur SKM,NRR per Unsur,NRR Tertimbang\n";
        $no = 1;
        foreach ($avgUnsur as $kode => $nilai) {
            $csv .= $no++ . "," . $unsurLabels[$kode] . "," .
                    number_format($nilai, 2) . "," .
                    number_format($nilai/9, 2) . "\n";
        }
        $csv .= "Nilai Indeks,," . number_format($nilaiIndeks, 2) . "\n";
        $csv .= "Nilai SKM Setelah Dikonversi (NI x 25),," . number_format($ikm, 2) . "\n\n";

        // Indeks Kepuasan Masyarakat dengan 5 kolom
        $csv .= "Indeks Kepuasan Masyarakat\nBidang Pelayanan,Nilai Indeks,Nilai IKM,Mutu Pelayanan,Kepuasan Masyarakat\n";
        $csv .= "$opdNama," . number_format($nilaiIndeks, 2) . "," .
                number_format($ikm, 2) . ",$mutu,$kepuasan\n";

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"laporan_ikm_{$opdKode}.csv\"",
        ]);
    }

    // Admin membuat draft laporan dari data survei (tanpa input manual)
    public function storeDraft($opdKode)
    {
        $responden = SurveyResponse::where('opd_kode', $opdKode)->where('completed', true)->get();

        if ($responden->isEmpty()) {
            return redirect()->back()->with('error', 'Belum ada data survei lengkap untuk OPD ini.');
        }

        $opdNama = $responden->first()->opd_nama ?? $opdKode;
        $ikm = round($responden->avg('nilai_ikm'), 2);

        LaporanIkm::create([
            'opd_kode' => $opdKode,
            'opd_nama' => $opdNama,
            'judul' => 'Laporan IKM ' . $opdNama,
            'ringkasan' => 'Draft laporan otomatis dari hasil rekap survei.',
            'nilai_ikm' => $ikm,
            'status' => 'draft',
            'created_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Draft laporan berhasil dibuat.');
    }

    // Admin kirim ke Kepala OPD (buat versi baru)
    public function sendToApproval($id)
    {
        $laporanLama = LaporanIkm::findOrFail($id);

        // Buat baris baru, bukan update baris lama
        LaporanIkm::create([
            'opd_kode'   => $laporanLama->opd_kode,
            'opd_nama'   => $laporanLama->opd_nama,
            'judul'      => $laporanLama->judul . ' (versi baru)',
            'ringkasan'  => $laporanLama->ringkasan,
            'nilai_ikm'  => $laporanLama->nilai_ikm,
            'status'     => 'waiting_approval',
            'created_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Laporan baru dikirim ke Kepala OPD.');
    }

    // Kepala OPD menyetujui laporan
    public function approve($id)
    {
        $laporan = LaporanIkm::findOrFail($id);
        $laporan->update([
            'status' => 'approved',
            'approved_by_kepala' => true,
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil disetujui.');
    }

    // Admin mempublikasikan laporan
    public function publish($id)
    {
        $laporan = LaporanIkm::findOrFail($id);
        $laporan->update([
            'status' => 'published',
            'published_by_admin' => Auth::id(),
            'published_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dipublikasikan.');
    }
}