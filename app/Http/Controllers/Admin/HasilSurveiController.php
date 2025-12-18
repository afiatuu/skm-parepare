<?php
// app\Http\Controllers\Admin\HasilSurveiController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;

class HasilSurveiController extends Controller
{
    public function index(Request $request)
    {
        // filter berdasarkan OPD jika ada
        $query = SurveyResponse::query()->where('completed', true);

        if ($request->filled('dinas_id')) {
            $query->where('dinas_id', $request->dinas_id);
        }

        // ✅ filter tanggal (range atau satu tanggal)
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        } elseif ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $data = $query->orderByDesc('created_at')
                      ->paginate(20)
                      ->withQueryString(); // supaya parameter filter ikut di pagination

        return view('admin.hasil_survei', compact('data'));
    }

    public function detail($id)
    {
        $respon = SurveyResponse::with('laporan')->findOrFail($id);
        return view('admin.hasil_survei_detail', compact('respon'));
    }

    public function export(Request $request)
    {
        $query = SurveyResponse::where('completed', true);

        // filter OPD
        if ($request->filled('dinas_id')) {
            $query->where('dinas_id', $request->dinas_id);
        }

        // filter tanggal juga di export
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        } elseif ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $data = $query->get();

        $csv = "Waktu,Nama,OPD,Usia,IKM,Saran\n";
        foreach ($data as $respon) {
            $csv .= "{$respon->created_at},{$respon->nama},{$respon->opd_nama},{$respon->usia},{$respon->nilai_ikm},{$respon->saran}\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename=\"hasil_survei.csv"');
    }
}