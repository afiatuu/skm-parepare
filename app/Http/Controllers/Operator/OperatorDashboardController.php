<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SurveyResponse;
use Carbon\Carbon;

class OperatorDashboardController extends Controller
{
    // ================== DASHBOARD ==================
    public function index()
    {
        $user = Auth::user();
        $opdKode = $user->opd_kode;

        if (!$opdKode) {
            abort(403, 'OPD user belum di-set.');
        }

        $today = now()->toDateString();

        $respondenHariIni = SurveyResponse::where('opd_kode', $opdKode)
            ->whereDate('created_at', $today)
            ->count();

        $respondenBulanIni = SurveyResponse::where('opd_kode', $opdKode)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $totalResponden = SurveyResponse::where('opd_kode', $opdKode)->count();

        $avgU = SurveyResponse::where('opd_kode', $opdKode)
            ->selectRaw('AVG((COALESCE(u1,0)+COALESCE(u2,0)+COALESCE(u3,0)+COALESCE(u4,0)+COALESCE(u5,0)+COALESCE(u6,0)+COALESCE(u7,0)+COALESCE(u8,0)+COALESCE(u9,0))/9) as avg_u')
            ->value('avg_u');

        $ikm = $avgU ? round($avgU * 25, 2) : 0;

        $latest = SurveyResponse::where('opd_kode', $opdKode)
            ->latest()
            ->limit(10)
            ->get([
                'id','nama','no_wa','gender','usia','pendidikan','pekerjaan',
                'u1','u2','u3','u4','u5','u6','u7','u8','u9','created_at'
            ]);

        return view('operator.dashboard', compact(
            'user',
            'opdKode',
            'respondenHariIni',
            'respondenBulanIni',
            'totalResponden',
            'ikm',
            'latest'
        ));
    }

    // ================== DATA RESPONDEN ==================
    public function dataResponden(Request $request)
    {
        $user = Auth::user();
        $opdKode = $user->opd_kode;

        if (!$opdKode) {
            abort(403, 'OPD user belum di-set.');
        }

        $query = SurveyResponse::where('opd_kode', $opdKode);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('nama', 'like', "%{$q}%")
                         ->orWhere('no_wa', 'like', "%{$q}%");
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $responses = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalResponden = SurveyResponse::where('opd_kode', $opdKode)->count();

        return view('operator.data-responden', compact(
            'user',
            'opdKode',
            'responses',
            'totalResponden'
        ));
    }

    // ================== LAPORAN IKM ==================
    public function laporanIkm()
    {
        $user = Auth::user();
        $opdKode = $user->opd_kode;

        if (!$opdKode) {
            abort(403, 'OPD user belum di-set.');
        }

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

        $unsurData = collect(); // gunakan Collection
        $sumIkm = 0;
        $countIkm = 0;

        for ($i = 1; $i <= 9; $i++) {
            $nilai = $avg?->{"u{$i}"} ?? 0;
            $ikmUnsur = $nilai ? round($nilai * 25, 2) : 0;

            $unsurData->push([
                'kode'  => "U{$i}",
                'nama'  => $unsur[$i],
                'nilai' => round($nilai, 2),
                'ikm'   => $ikmUnsur,
            ]);

            if ($ikmUnsur > 0) {
                $sumIkm += $ikmUnsur;
                $countIkm++;
            }
        }

        $ikmRata = $countIkm ? round($sumIkm / $countIkm, 2) : 0;
        $totalResponden = SurveyResponse::where('opd_kode', $opdKode)->count();

        // Data tren per bulan
        $trendData = SurveyResponse::selectRaw('MONTH(created_at) as bulan, AVG((u1+u2+u3+u4+u5+u6+u7+u8+u9)/9)*25 as ikm')
            ->where('opd_kode', $opdKode)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->map(function ($row) {
                return [
                    'bulan' => Carbon::create()->month($row->bulan)->format('M'),
                    'ikm'   => round($row->ikm, 2),
                ];
            });

        return view('operator.laporan-ikm', compact(
            'user',
            'opdKode',
            'unsurData',
            'ikmRata',
            'totalResponden',
            'trendData'
        ));
    }
}