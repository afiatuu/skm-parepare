<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LaporanIkm;
use App\Models\SurveyResponse;

class KepalaDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $opdKode = $user->opd_kode;

        if (!$opdKode) {
            abort(403, 'OPD user belum di-set.');
        }

        // ringkasan
        $today = now()->toDateString();

        $respondenHariIni = SurveyResponse::where('opd_kode', $opdKode)
            ->whereDate('created_at', $today)
            ->count();

        $respondenBulanIni = SurveyResponse::where('opd_kode', $opdKode)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $totalResponden = SurveyResponse::where('opd_kode', $opdKode)->count();

        // IKM (rata-rata unsur x 25)
        $avgU = SurveyResponse::where('opd_kode', $opdKode)
            ->selectRaw('AVG((COALESCE(u1,0)+COALESCE(u2,0)+COALESCE(u3,0)+COALESCE(u4,0)+COALESCE(u5,0)+COALESCE(u6,0)+COALESCE(u7,0)+COALESCE(u8,0)+COALESCE(u9,0))/9) as avg_u')
            ->value('avg_u');

        $ikm = $avgU ? round($avgU * 25, 2) : 0;

        // unsur untuk tabel ringkas
        $unsur = [
            1 => 'Persyaratan',
            2 => 'Prosedur',
            3 => 'Waktu Penyelesaian',
            4 => 'Biaya/Tarif',
            5 => 'Produk Pelayanan',
            6 => 'Kompetensi Petugas',
            7 => 'Perilaku Petugas',
            8 => 'Sarana dan Prasarana',
            9 => 'Penanganan Pengaduan',
        ];

        $avg = SurveyResponse::where('opd_kode', $opdKode)
            ->selectRaw('
                AVG(u1) as u1, AVG(u2) as u2, AVG(u3) as u3,
                AVG(u4) as u4, AVG(u5) as u5, AVG(u6) as u6,
                AVG(u7) as u7, AVG(u8) as u8, AVG(u9) as u9
            ')
            ->first();

        $unsurData = [];
        for ($i = 1; $i <= 9; $i++) {
            $nilai = $avg?->{"u{$i}"} ?? 0;
            $unsurData[] = [
                'kode' => "U{$i}",
                'nama' => $unsur[$i],
                'nilai' => round((float)$nilai, 2),
                'ikm' => $nilai ? round($nilai * 25, 2) : 0,
            ];
        }

        // saran terbaru
        $saranTerbaru = SurveyResponse::where('opd_kode', $opdKode)
            ->whereNotNull('saran')
            ->where('saran', '!=', '')
            ->latest()
            ->limit(5)
            ->get(['nama','saran','created_at']);

        // daftar laporan IKM untuk tabel persetujuan
        $laporan = LaporanIkm::where('opd_kode', $opdKode)
            ->latest()
            ->limit(10)
            ->get();

        return view('kepala.dashboard', compact(
            'user',
            'opdKode',
            'respondenHariIni',
            'respondenBulanIni',
            'totalResponden',
            'ikm',
            'unsurData',
            'saranTerbaru',
            'laporan'
        ));
    }
}