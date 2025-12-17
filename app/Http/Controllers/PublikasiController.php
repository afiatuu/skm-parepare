<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanIkm;   
use App\Models\Opd;
use App\Models\SurveyResponse;         

class PublikasiController extends Controller
{
    public function index()
    {
        $laporanPublished = LaporanIkm::where('status', 'published')->with('opd')->get();

        $opdList = $laporanPublished->map(function ($laporan, $index) {
            $ikm = $laporan->nilai_ikm ?? 0;
            $stars = $ikm >= 85 ? 5 : ($ikm >= 75 ? 4 : ($ikm >= 65 ? 3 : ($ikm >= 50 ? 2 : 1)));

            return [
                'no'         => $index + 1,
                'opd_nama'   => $laporan->opd->nama ?? 'OPD Tidak Dikenal',
                'ikm'        => $ikm,
                'responden'  => $laporan->responden()->count(),
                'stars'      => $stars,
                'detail_url' => route('publikasi.detail', $laporan->id),
            ];
        });

        return view('publikasi.laporan', compact('opdList'));
    }

    public function detail($id)
    {
        // Ambil laporan yang sudah dipublikasikan + relasi OPD
        $laporan = LaporanIkm::with('opd')->where('id', $id)->where('status', 'published')->firstOrFail();

        // Tentukan nama OPD dengan fallback aman
        $opdNama = $laporan->opd->nama ?? $laporan->opd_nama ?? $laporan->opd_kode;

        // Ambil responden untuk OPD ini
        $responden = SurveyResponse::where('opd_kode', $laporan->opd_kode)
            ->where('completed', true)
            ->get();

        // Distribusi karakteristik
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

        // Rata-rata unsur u1..u9
        $avgUnsur = [
            'u1' => round($responden->avg('u1'), 2),
            'u2' => round($responden->avg('u2'), 2),
            'u3' => round($responden->avg('u3'), 2),
            'u4' => round($responden->avg('u4'), 2),
            'u5' => round($responden->avg('u5'), 2),
            'u6' => round($responden->avg('u6'), 2),
            'u7' => round($responden->avg('u7'), 2),
            'u8' => round($responden->avg('u8'), 2),
            'u9' => round($responden->avg('u9'), 2),
        ];

        // Nilai indeks & IKM
        $nilaiIndeks = collect($avgUnsur)->avg() ?? 0;
        $ikm = round($nilaiIndeks * 25, 2);

        // Mutu pelayanan
        if ($ikm >= 88.31) {
            $mutu = 'A';
        } elseif ($ikm >= 76.61) {
            $mutu = 'B';
        } elseif ($ikm >= 65.00) {
            $mutu = 'C';
        } elseif ($ikm >= 25.00) {
            $mutu = 'D';
        } else {
            $mutu = '-';
        }

        return view('publikasi.detail', compact(
            'laporan',
            'opdNama',
            'responden',
            'gender',
            'usia',
            'pendidikan',
            'pekerjaan',
            'avgUnsur',
            'nilaiIndeks',
            'ikm',
            'mutu'
        ));
    }

    public function home()
    {
        $laporanPublished = LaporanIkm::where('status', 'published')
            ->with('opd')
            ->orderBy('approved_at', 'desc') // urutkan berdasarkan waktu publish
            ->take(3)                        // ambil hanya 3 data
            ->get();

        $cards = $laporanPublished->map(function ($laporan) {
            $ikm = $laporan->nilai_ikm ?? null;
            $stars = $ikm >= 85 ? 5 : ($ikm >= 75 ? 4 : ($ikm >= 65 ? 3 : ($ikm >= 50 ? 2 : 1)));

            return [
                'nama' => $laporan->opd->nama ?? $laporan->opd_nama ?? 'OPD Tidak Dikenal',
                'sub'  => $laporan->judul ?? 'Laporan IKM',
                'ikm'  => $ikm ? number_format($ikm, 2) : '–',
                'stars'=> $stars,
                'url'  => route('publikasi.laporan'), // arahkan ke halaman rekap semua publikasi
            ];
        });

        return view('home', compact('cards'));
    }
}