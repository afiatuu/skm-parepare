<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\PublikasiController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DinasLayananController;
use App\Http\Controllers\Admin\PertanyaanSkmController;
use App\Http\Controllers\Admin\HasilSurveiController;
use App\Http\Controllers\Admin\LaporanIkmController;
use App\Http\Controllers\Admin\ArsipController;

use App\Http\Controllers\Operator\OperatorDashboardController;
use App\Http\Controllers\Kepala\KepalaApprovalController;
use App\Http\Controllers\Kepala\KepalaDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

// ================== ROUTE PILIH OPD =====================
Route::get('/survey/opd', [SurveyController::class, 'opdSelect'])->name('survey.opd.select');
Route::post('/survey/opd', [SurveyController::class, 'opdSelectPost'])->name('survey.opd.select.post');

Route::get('/survey/opd/kategori/{kategori}', [SurveyController::class, 'opdByKategori'])->name('survey.opd.byKategori');
Route::post('/survey/opd/kategori/{kategori}', [SurveyController::class, 'opdByKategoriPost'])->name('survey.opd.byKategori.post');

Route::get('/survey/opd/{dinasId}', [SurveyController::class, 'opdDetail'])->name('survey.opd.detail');

// ================== ROUTE SURVEY (STEP 1–17) =====================
Route::get('/survey/step-1', [SurveyController::class, 'step1'])->name('survey.step1');
Route::post('/survey/step-1', [SurveyController::class, 'step1Post'])->name('survey.step1.post');

Route::get('/survey/step-2', [SurveyController::class, 'step2'])->name('survey.step2');
Route::post('/survey/step-2', [SurveyController::class, 'step2Post'])->name('survey.step2.post');

Route::get('/survey/step-3', [SurveyController::class, 'step3'])->name('survey.step3');
Route::post('/survey/step-3', [SurveyController::class, 'step3Post'])->name('survey.step3.post');

Route::get('/survey/step-4', [SurveyController::class, 'step4'])->name('survey.step4');
Route::post('/survey/step-4', [SurveyController::class, 'step4Post'])->name('survey.step4.post');

Route::get('/survey/step-5', [SurveyController::class, 'step5'])->name('survey.step5');
Route::post('/survey/step-5', [SurveyController::class, 'step5Post'])->name('survey.step5.post');

Route::get('/survey/step-6', [SurveyController::class, 'step6'])->name('survey.step6');
Route::post('/survey/step-6', [SurveyController::class, 'step6Post'])->name('survey.step6.post');

Route::get('/survey/step-7', [SurveyController::class, 'step7'])->name('survey.step7');
Route::post('/survey/step-7', [SurveyController::class, 'step7Post'])->name('survey.step7.post');

Route::get('/survey/step-8', [SurveyController::class, 'step8'])->name('survey.step8');
Route::post('/survey/step-8', [SurveyController::class, 'step8Post'])->name('survey.step8.post');

Route::get('/survey/step-9', [SurveyController::class, 'step9'])->name('survey.step9');
Route::post('/survey/step-9', [SurveyController::class, 'step9Post'])->name('survey.step9.post');

Route::get('/survey/step-10', [SurveyController::class, 'step10'])->name('survey.step10');
Route::post('/survey/step-10', [SurveyController::class, 'step10Post'])->name('survey.step10.post');

Route::get('/survey/step-11', [SurveyController::class, 'step11'])->name('survey.step11');
Route::post('/survey/step-11', [SurveyController::class, 'step11Post'])->name('survey.step11.post');

Route::get('/survey/step-12', [SurveyController::class, 'step12'])->name('survey.step12');
Route::post('/survey/step-12', [SurveyController::class, 'step12Post'])->name('survey.step12.post');

Route::get('/survey/step-13', [SurveyController::class, 'step13'])->name('survey.step13');
Route::post('/survey/step-13', [SurveyController::class, 'step13Post'])->name('survey.step13.post');

Route::get('/survey/step-14', [SurveyController::class, 'step14'])->name('survey.step14');
Route::post('/survey/step-14', [SurveyController::class, 'step14Post'])->name('survey.step14.post');

Route::get('/survey/step-15', [SurveyController::class, 'step15'])->name('survey.step15');
Route::post('/survey/step-15', [SurveyController::class, 'step15Post'])->name('survey.step15.post');

Route::get('/survey/step-16', [SurveyController::class, 'step16'])->name('survey.step16');
Route::post('/survey/step-16', [SurveyController::class, 'step16Post'])->name('survey.step16.post');

Route::get('/survey/step-17', [SurveyController::class, 'step17'])->name('survey.step17');
Route::post('/survey/step-17', [SurveyController::class, 'step17Post'])->name('survey.step17.post');

// ================== PROFILE =====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================== DASHBOARD BY ROLE =====================
Route::middleware(['auth', 'verified'])->group(function () {

    // /dashboard = pintu masuk (redirect sesuai role)
    Route::get('/dashboard', function () {
        $role = optional(auth()->user()->role)->name;

        return match ($role) {
            'admin'      => redirect()->route('admin.dashboard'),
            'operator'   => redirect()->route('operator.dashboard'),
            'kepala_opd' => redirect()->route('kepala.dashboard'),
            default      => redirect()->route('home'),
        };
    })->name('dashboard');

    // ================== ADMIN PANEL ROUTES =====================
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

            // Profil Akun
            Route::get('/profil', [\App\Http\Controllers\Admin\ProfilController::class, 'index'])->name('profil');
            Route::put('/profil', [\App\Http\Controllers\Admin\ProfilController::class, 'update'])->name('profil.update');

            Route::get('/dinas-layanan', [DinasLayananController::class, 'index'])->name('dinas_layanan');
            Route::post('/dinas', [DinasLayananController::class, 'storeDinas'])->name('dinas.store');
            Route::put('/dinas/{dinas}', [DinasLayananController::class, 'updateDinas'])->name('dinas.update');
            Route::delete('/dinas/{dinas}', [DinasLayananController::class, 'destroyDinas'])->name('dinas.destroy');
            Route::post('/layanan', [DinasLayananController::class, 'storeLayanan'])->name('layanan.store');
            Route::put('/layanan/{service}', [DinasLayananController::class, 'updateLayanan'])->name('layanan.update');
            Route::delete('/layanan/{service}', [DinasLayananController::class, 'destroyLayanan'])->name('layanan.destroy');

            Route::get('/pertanyaan-skm', [PertanyaanSkmController::class, 'index'])->name('pertanyaan_skm');
            Route::post('/pertanyaan-skm', [PertanyaanSkmController::class, 'store'])->name('pertanyaan_skm.store');
            Route::put('/pertanyaan-skm/{question}', [PertanyaanSkmController::class, 'update'])->name('pertanyaan_skm.update');
            Route::delete('/pertanyaan-skm/{question}', [PertanyaanSkmController::class, 'destroy'])->name('pertanyaan_skm.destroy');

            // Hasil Survei
            Route::get('/hasil-survei', [HasilSurveiController::class, 'index'])->name('hasil_survei');
            Route::get('/hasil-survei/{id}', [HasilSurveiController::class, 'detail'])->name('hasil_survei.detail');
            Route::get('/hasil-survei/export', [HasilSurveiController::class, 'export'])->name('hasil_survei.export');
            
            // Laporan IKM
            Route::get('/laporan-ikm', [LaporanIkmController::class, 'index'])->name('laporan_ikm');
            Route::get('/laporan-ikm/{opdKode}', [LaporanIkmController::class, 'detailOpd'])->name('laporan_ikm.detail');
            Route::get('/laporan-ikm/export-pdf', [LaporanIkmController::class, 'exportPdf'])->name('laporan_ikm.exportPdf');
            Route::get('/laporan-ikm/export-excel', [LaporanIkmController::class, 'exportExcel'])->name('laporan_ikm.exportExcel');

            // Export detail per OPD
            Route::get('/laporan-ikm/{opdKode}/export-pdf', [LaporanIkmController::class, 'exportDetailPdf'])->name('laporan_ikm.exportDetailPdf');
            Route::get('/laporan-ikm/{opdKode}/export-excel', [LaporanIkmController::class, 'exportDetailExcel'])->name('laporan_ikm.exportDetailExcel');
            
            // Workflow laporan
            Route::post('/laporan-ikm/{opdKode}/buat-draft', [LaporanIkmController::class, 'storeDraft'])->name('laporan_ikm.storeDraft');
            Route::post('/laporan-ikm/{id}/kirim', [LaporanIkmController::class, 'sendToApproval'])->name('laporan_ikm.kirim');
            Route::post('/laporan-ikm/{id}/approve', [LaporanIkmController::class, 'approve'])->name('laporan_ikm.approve');
            Route::post('/laporan-ikm/{id}/publish', [LaporanIkmController::class, 'publish'])->name('laporan_ikm.publish');

            //route arsip laporan
            Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
            Route::get('/arsip/{id}', [LaporanIkmController::class, 'detailArsip'])->name('laporan_ikm.detailArsip');

        });

    // ================== OPERATOR OPD ROUTES =====================
    Route::middleware(['role:operator'])->group(function () {
        Route::get('/operator', [OperatorDashboardController::class, 'index'])->name('operator.dashboard');
        Route::get('/operator/data-responden', [OperatorDashboardController::class, 'dataResponden'])->name('operator.data-responden');
        Route::get('/operator/laporan-ikm', [OperatorDashboardController::class, 'laporanIkm'])->name('operator.laporan-ikm');
        Route::post('/operator/data-responden', [OperatorDashboardController::class, 'storeResponden']) ->name('operator.data-responden.store');
        });

    // ================== KEPALA OPD ROUTES =====================
    Route::middleware(['role:kepala_opd'])->prefix('kepala-opd')->group(function () {
        Route::get('/', [KepalaDashboardController::class, 'index'])->name('kepala.dashboard');
        Route::post('/approve/{id}', [KepalaApprovalController::class, 'approve'])->name('kepala.approve');
    });
});

// ================== PUBLIKASI =====================
Route::get('/', [PublikasiController::class, 'home'])->name('home');
Route::get('/publikasi', [PublikasiController::class, 'index'])->name('publikasi.laporan');
Route::get('/publikasi/detail/{opd_kode}', [PublikasiController::class, 'detail'])->name('publikasi.detail');

require __DIR__ . '/auth.php';