<?php
// app\Http\Controllers\Admin\DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveyResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $respondenHariIni = SurveyResponse::whereDate('created_at', now()->toDateString())->count();

        $respondenBulanIni = SurveyResponse::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        // rata-rata unsur (1-4) -> dikonversi ke IKM skala 1-100 (x25)
        $avgUnsur = SurveyResponse::whereNotNull('u1')
            ->avg(DB::raw('(u1+u2+u3+u4+u5+u6+u7+u8+u9)/9'));

        $avgIkm = $avgUnsur ? round($avgUnsur * 25, 2) : 0;

        return view('admin.dashboard', compact('respondenHariIni', 'respondenBulanIni', 'avgIkm'));
    }
}