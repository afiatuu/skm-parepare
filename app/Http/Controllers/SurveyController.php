<?php
// app\Http\Controllers\SurveyController.php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\Service;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    protected int $totalSteps = 17;

    // ================== HELPERS ==================
    private function currentResponseOrFail(): SurveyResponse
    {
        $id = session('survey.response_id');
        if (! $id) {
            abort(419, 'Session survei tidak ditemukan. Silakan mulai dari awal.');
        }
        return SurveyResponse::findOrFail($id);
    }

    // ================== ALUR OPD (SEBELUM STEP 1) ==================

    // 1) Pilih kategori (Dinas / Kesehatan / Kecamatan)
    public function opdSelect()
    {
        $kategoriOpd = [
            'dinas'     => 'Dinas',
            'kesehatan' => 'Layanan Kesehatan',
            'kecamatan' => 'Kecamatan',
        ];

        return view('survey.opd-select', compact('kategoriOpd'));
    }

    public function opdSelectPost(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:dinas,kesehatan,kecamatan',
        ]);

        $label = [
            'dinas'     => 'Dinas',
            'kesehatan' => 'Layanan Kesehatan',
            'kecamatan' => 'Kecamatan',
        ][$request->kategori];

        session([
            'survey.kategori_opd_slug' => $request->kategori,
            'survey.kategori_opd_nama' => $label,
        ]);

        return redirect()->route('survey.opd.byKategori', $request->kategori);
    }

    // 2) Daftar OPD per kategori (ambil dari tabel dinas)
    public function opdByKategori(string $kategori)
    {
        if (!in_array($kategori, ['dinas', 'kesehatan', 'kecamatan'])) {
            abort(404);
        }

        $kategoriLabel = [
            'dinas'     => 'Dinas',
            'kesehatan' => 'Layanan Kesehatan',
            'kecamatan' => 'Kecamatan',
        ][$kategori];

        // mapping slug -> category_id
        $categoryId = match ($kategori) {
            'dinas' => 1,
            'kesehatan' => 2,
            'kecamatan' => 3,
        };

        // ambil daftar dinas berdasarkan category_id
        $opsi = Opd::query()
            ->where('category_id', $categoryId)
            ->orderBy('nama')
            ->get(['kode','nama'])
            ->mapWithKeys(fn($opd) => [
                $opd->kode => $opd->nama . ' (' . $opd->kode . ')'
            ])
            ->toArray();

        return view('survey.opd-by-kategori', compact('kategori', 'kategoriLabel', 'opsi'));
    }

    // POST pilih OPD (dinas_id) -> langsung ke STEP 1
    public function opdByKategoriPost(Request $request, string $kategori)
    {
        if (!in_array($kategori, ['dinas', 'kesehatan', 'kecamatan'])) {
            abort(404);
        }

        $categoryId = match ($kategori) {
            'dinas' => 1,
            'kesehatan' => 2,
            'kecamatan' => 3,
        };

        $request->validate([
            'opd' => 'required|string|exists:opd,kode',
        ]);

        $opd = Opd::where('kode', $request->opd)
            ->where('category_id', $categoryId)
            ->firstOrFail();

        session([
            'survey.kode_opd'   => $opd->kode,
            'survey.nama_opd'   => $opd->nama,
            'survey.category_id'=> $categoryId,
            
            'survey.service_id'  => null,
            'survey.layanan'     => null,
            'survey.response_id' => null,
        ]);

        return redirect()->route('survey.step1');
    }

    // ===================== STEP 1 =====================
    public function step1()
    {
        if (!session('survey.kode_opd')) {
            return redirect()->route('survey.opd.select')
                ->with('error', 'Silakan pilih OPD terlebih dahulu.');
        }

        $currentStep     = 1;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        $kodeOpd = session('survey.kode_opd');

        // ✅ PERBAIKAN: Tidak perlu mengambil OPD, langsung filter dengan kode_opd
        $layananOptions = Service::query()
            ->where('kode_opd', $kodeOpd) // ✅ GANTI 'opd_id' dengan 'kode_opd'
            ->orderBy('nama')
            ->get(['id', 'nama']);

        return view('survey.step1', compact(
            'currentStep',
            'totalSteps',
            'progressPercent',
            'layananOptions'
        ));
    }

    public function step1Post(Request $request)
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'no_wa'      => 'required|string|max:20',
            'service_id' => 'required|exists:services,id',
        ]);

        $kodeOpd   = session('survey.kode_opd');
        $namaOpd   = session('survey.nama_opd');
        $categoryId = session('survey.category_id');

        if (!$kodeOpd) {
            abort(419, 'Session OPD tidak ditemukan. Silakan mulai dari awal.');
        }

        // ambil OPD berdasarkan KODE
        $opd = Opd::where('kode', $kodeOpd)->firstOrFail();

        // ✅ PERBAIKAN: Filter dengan kode_opd bukan opd_id
        $service = Service::query()
            ->where('id', $validated['service_id'])
            ->where('kode_opd', $kodeOpd) // ✅ GANTI 'opd_id' dengan 'kode_opd'
            ->firstOrFail();

        // simpan ke session
        session([
            'survey.nama'       => $validated['nama'],
            'survey.no_wa'      => $validated['no_wa'],
            'survey.service_id' => $service->id,
            'survey.layanan'    => $service->nama,
        ]);

        // BUAT survey_responses (TANPA opd_id & dinas_id)
        $sr = SurveyResponse::create([
            'nama'         => $validated['nama'],
            'no_wa'        => $validated['no_wa'],
            'category_id'  => $categoryId,

            'opd_kode'     => $opd->kode, // ✅ KONSISTEN: opd_kode bukan kode_opd
            'opd_nama'     => $opd->nama,

            'service_id'   => $service->id,
            'layanan_nama' => $service->nama,
        ]);

        session(['survey.response_id' => $sr->id]);

        return redirect()->route('survey.step2');
    }

    // ===================== STEP 2 =====================
    public function step2()
    {
        $currentStep     = 2;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        return view('survey.step2', compact('currentStep', 'totalSteps', 'progressPercent'));
    }

    public function step2Post(Request $request)
    {
        $request->validate([
            'gender' => 'required|in:Laki-laki,Perempuan',
        ]);

        session(['survey.gender' => $request->gender]);

        $sr = $this->currentResponseOrFail();
        $sr->update(['gender' => $request->gender]);

        return redirect()->route('survey.step3');
    }

    // ===================== STEP 3 =====================
    public function step3()
    {
        $currentStep     = 3;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        $usiaOptions = [
            '< 12 Tahun',
            '12–25 Tahun',
            '26–45 Tahun',
            '46–65 Tahun',
        ];

        return view('survey.step3', compact('currentStep', 'totalSteps', 'progressPercent', 'usiaOptions'));
    }

    public function step3Post(Request $request)
    {
        $request->validate(['usia' => 'required|string']);

        session(['survey.usia' => $request->usia]);

        $sr = $this->currentResponseOrFail();
        $sr->update(['usia' => $request->usia]);

        return redirect()->route('survey.step4');
    }

    // ===================== STEP 4 =====================
    public function step4()
    {
        $currentStep     = 4;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        return view('survey.step4', compact('currentStep', 'totalSteps', 'progressPercent'));
    }

    public function step4Post(Request $request)
    {
        $request->validate(['pendidikan' => 'required|string']);

        session(['survey.pendidikan' => $request->pendidikan]);

        $sr = $this->currentResponseOrFail();
        $sr->update(['pendidikan' => $request->pendidikan]);

        return redirect()->route('survey.step5');
    }

    // ===================== STEP 5 =====================
    public function step5()
    {
        $currentStep     = 5;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        return view('survey.step5', compact('currentStep', 'totalSteps', 'progressPercent'));
    }

    public function step5Post(Request $request)
    {
        $request->validate(['pekerjaan' => 'required|string']);

        session(['survey.pekerjaan' => $request->pekerjaan]);

        $sr = $this->currentResponseOrFail();
        $sr->update(['pekerjaan' => $request->pekerjaan]);

        return redirect()->route('survey.step6');
    }

    // ===================== STEP 6 =====================
    public function step6()
    {
        $currentStep     = 6;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        $kecamatanOptions = [
            'Kecamatan Bacukiki',
            'Kecamatan Bacukiki Barat',
            'Kecamatan Ujung',
            'Kecamatan Soreang',
        ];

        return view('survey.step6', compact('currentStep', 'totalSteps', 'progressPercent', 'kecamatanOptions'));
    }

    public function step6Post(Request $request)
    {
        $request->validate(['kecamatan' => 'required|string']);

        session(['survey.kecamatan' => $request->kecamatan]);

        $sr = $this->currentResponseOrFail();
        $sr->update(['kecamatan' => $request->kecamatan]);

        return redirect()->route('survey.step7');
    }

    // ===================== STEP 7 =====================
    public function step7()
    {
        $currentStep     = 7;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        $kecamatan = session('survey.kecamatan');
        if (! $kecamatan) {
            return redirect()->route('survey.step6')->with('error', 'Silakan pilih kecamatan terlebih dahulu.');
        }

        $kelurahanMap = [
            'Kecamatan Bacukiki' => ['Galung Maloang','Lemoe','Lompoe','Wattang Bacukiki,'],
            'Kecamatan Bacukiki Barat' => ['Bumi Harapan','Cappa Galung','Kampung Baru','Lumpue','Sumpang Minangae','Tito Sompe'],
            'Kecamatan Ujung' => ['Bukit Harapan','Bukit Indah','Kampung Pisang','Lakessi','Ujung Baru','Ujung Lare','Wattang Soreang'],
            'Kecamatan Soreang' => ['Labukkang','Lapadde','Mallusetasi','Ujung Bulu','Ujung Sabbang'],
        ];

        $kelurahanOptions = $kelurahanMap[$kecamatan] ?? [];
        $row1 = $kelurahanOptions;
        $row2 = [];

        if ($kecamatan === 'Kecamatan Bacukiki Barat' && count($kelurahanOptions) >= 6) {
            $row1 = array_slice($kelurahanOptions, 0, 3);
            $row2 = array_slice($kelurahanOptions, 3);
        } elseif ($kecamatan === 'Kecamatan Ujung' && count($kelurahanOptions) >= 7) {
            $row1 = array_slice($kelurahanOptions, 0, 4);
            $row2 = array_slice($kelurahanOptions, 4);
        }

        return view('survey.step7', compact(
            'currentStep','totalSteps','progressPercent',
            'kecamatan','kelurahanOptions','row1','row2'
        ));
    }

    public function step7Post(Request $request)
    {
        $request->validate(['kelurahan' => 'required|string']);

        session(['survey.kelurahan' => $request->kelurahan]);

        $sr = $this->currentResponseOrFail();
        $sr->update(['kelurahan' => $request->kelurahan]);

        return redirect()->route('survey.step8');
    }

    // ===================== STEP 8 =====================
    public function step8()
    {
        $currentStep     = 8;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        $pertanyaan = 'Bagaimana pendapat Saudara tentang kemudahan persyaratan untuk memperoleh pelayanan ?';

        $skalaOptions = [
            1 => ['label' => 'Tidak Baik',   'icon' => 'tidak baik.png'],
            2 => ['label' => 'Kurang Baik',  'icon' => 'kurang baik.png'],
            3 => ['label' => 'Baik',         'icon' => 'baik.png'],
            4 => ['label' => 'Sangat Baik',  'icon' => 'sangat baik.png'],
        ];

        $selected = session('survey.ikm.1');

        return view('survey.step8', compact('currentStep','totalSteps','progressPercent','pertanyaan','skalaOptions','selected'));
    }

    public function step8Post(Request $request)
    {
        $request->validate(['ikm_1' => 'required|integer|between:1,4']);

        $ikm = session('survey.ikm', []);
        $ikm[1] = (int) $request->ikm_1;
        session(['survey.ikm' => $ikm]);

        $sr = $this->currentResponseOrFail();
        $sr->update(['u1' => (int) $request->ikm_1]);

        return redirect()->route('survey.step9');
    }

    // ===================== STEP 9 =====================
    public function step9()
    {
        $currentStep     = 9;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        $pertanyaan = 'Bagaimana kemudahan prosedur untuk memperoleh pelayanan?';

        $skalaOptions = [
            1 => ['label' => 'Tidak Baik',   'icon' => 'tidak baik.png'],
            2 => ['label' => 'Kurang Baik',  'icon' => 'kurang baik.png'],
            3 => ['label' => 'Baik',         'icon' => 'baik.png'],
            4 => ['label' => 'Sangat Baik',  'icon' => 'sangat baik.png'],
        ];

        $selected = session('survey.ikm.2');

        return view('survey.step9', compact('currentStep','totalSteps','progressPercent','pertanyaan','skalaOptions','selected'));
    }

    public function step9Post(Request $request)
    {
        $request->validate(['ikm_2' => 'required|integer|between:1,4']);

        $ikm = session('survey.ikm', []);
        $ikm[2] = (int) $request->ikm_2;
        session(['survey.ikm' => $ikm]);

        $sr = $this->currentResponseOrFail();
        $sr->update(['u2' => (int) $request->ikm_2]);

        return redirect()->route('survey.step10');
    }

    // ===================== STEP 10 =====================
    public function step10()
    {
        $currentStep     = 10;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        $pertanyaan = 'Bagaimana kecepatan/waktu yang dibutuhkan hingga Saudara memperoleh pelayanan ?';

        $skalaOptions = [
            1 => ['label' => 'Tidak Baik',   'icon' => 'tidak baik.png'],
            2 => ['label' => 'Kurang Baik',  'icon' => 'kurang baik.png'],
            3 => ['label' => 'Baik',         'icon' => 'baik.png'],
            4 => ['label' => 'Sangat Baik',  'icon' => 'sangat baik.png'],
        ];

        $selected = session('survey.ikm.3');

        return view('survey.step10', compact('currentStep','totalSteps','progressPercent','pertanyaan','skalaOptions','selected'));
    }

    public function step10Post(Request $request)
    {
        $request->validate(['ikm_3' => 'required|integer|between:1,4']);

        $ikm = session('survey.ikm', []);
        $ikm[3] = (int) $request->ikm_3;
        session(['survey.ikm' => $ikm]);

        $sr = $this->currentResponseOrFail();
        $sr->update(['u3' => (int) $request->ikm_3]);

        return redirect()->route('survey.step11');
    }

    // ===================== STEP 11 =====================
    public function step11()
    {
        $currentStep     = 11;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        $pertanyaan = 'Apakah Saudara pernah dimintakan biaya/tarif lain diluar ketentuan persyaratan untuk memperoleh pelayanan ?';

        $skalaOptions = [
            1 => ['label' => 'Tidak Baik',   'icon' => 'tidak baik.png'],
            2 => ['label' => 'Kurang Baik',  'icon' => 'kurang baik.png'],
            3 => ['label' => 'Baik',         'icon' => 'baik.png'],
            4 => ['label' => 'Sangat Baik',  'icon' => 'sangat baik.png'],
        ];

        $selected = session('survey.ikm.4');

        return view('survey.step11', compact('currentStep','totalSteps','progressPercent','pertanyaan','skalaOptions','selected'));
    }

    public function step11Post(Request $request)
    {
        $request->validate(['ikm_4' => 'required|integer|between:1,4']);

        $ikm = session('survey.ikm', []);
        $ikm[4] = (int) $request->ikm_4;
        session(['survey.ikm' => $ikm]);

        $sr = $this->currentResponseOrFail();
        $sr->update(['u4' => (int) $request->ikm_4]);

        return redirect()->route('survey.step12');
    }

    // ===================== STEP 12 =====================
    public function step12()
    {
        $currentStep     = 12;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        $pertanyaan = 'Bagaimana pendapat Saudara tentang kualitas produk/jasa/tindakan administratif yang diberikan oleh unit pelayanan ?';

        $skalaOptions = [
            1 => ['label' => 'Tidak Baik',   'icon' => 'tidak baik.png'],
            2 => ['label' => 'Kurang Baik',  'icon' => 'kurang baik.png'],
            3 => ['label' => 'Baik',         'icon' => 'baik.png'],
            4 => ['label' => 'Sangat Baik',  'icon' => 'sangat baik.png'],
        ];

        $selected = session('survey.ikm.5');

        return view('survey.step12', compact('currentStep','totalSteps','progressPercent','pertanyaan','skalaOptions','selected'));
    }

    public function step12Post(Request $request)
    {
        $request->validate(['ikm_5' => 'required|integer|between:1,4']);

        $ikm = session('survey.ikm', []);
        $ikm[5] = (int) $request->ikm_5;
        session(['survey.ikm' => $ikm]);

        $sr = $this->currentResponseOrFail();
        $sr->update(['u5' => (int) $request->ikm_5]);

        return redirect()->route('survey.step13');
    }

    // ===================== STEP 13 =====================
    public function step13()
    {
        $currentStep     = 13;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        $pertanyaan = 'Bagaimana pendapat Saudara tentang kompetensi/kemampuan petugas yang memberikan pelayanan ?';

        $skalaOptions = [
            1 => ['label' => 'Tidak Baik',   'icon' => 'tidak baik.png'],
            2 => ['label' => 'Kurang Baik',  'icon' => 'kurang baik.png'],
            3 => ['label' => 'Baik',         'icon' => 'baik.png'],
            4 => ['label' => 'Sangat Baik',  'icon' => 'sangat baik.png'],
        ];

        $selected = session('survey.ikm.6');

        return view('survey.step13', compact('currentStep','totalSteps','progressPercent','pertanyaan','skalaOptions','selected'));
    }

    public function step13Post(Request $request)
    {
        $request->validate(['ikm_6' => 'required|integer|between:1,4']);

        $ikm = session('survey.ikm', []);
        $ikm[6] = (int) $request->ikm_6;
        session(['survey.ikm' => $ikm]);

        $sr = $this->currentResponseOrFail();
        $sr->update(['u6' => (int) $request->ikm_6]);

        return redirect()->route('survey.step14');
    }

    // ===================== STEP 14 =====================
    public function step14()
    {
        $currentStep     = 14;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        $pertanyaan = 'Bagaimana pendapat Saudara terhadap perilaku petugas yang memberikan pelayanan ?';

        $skalaOptions = [
            1 => ['label' => 'Tidak Baik',   'icon' => 'tidak baik.png'],
            2 => ['label' => 'Kurang Baik',  'icon' => 'kurang baik.png'],
            3 => ['label' => 'Baik',         'icon' => 'baik.png'],
            4 => ['label' => 'Sangat Baik',  'icon' => 'sangat baik.png'],
        ];

        $selected = session('survey.ikm.7');

        return view('survey.step14', compact('currentStep','totalSteps','progressPercent','pertanyaan','skalaOptions','selected'));
    }

    public function step14Post(Request $request)
    {
        $request->validate(['ikm_7' => 'required|integer|between:1,4']);

        $ikm = session('survey.ikm', []);
        $ikm[7] = (int) $request->ikm_7;
        session(['survey.ikm' => $ikm]);

        $sr = $this->currentResponseOrFail();
        $sr->update(['u7' => (int) $request->ikm_7]);

        return redirect()->route('survey.step15');
    }

    // ===================== STEP 15 =====================
    public function step15()
    {
        $currentStep     = 15;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        $pertanyaan = 'Bagaimana pendapat Saudara tentang kualitas sarana dan prasarana yang ada di ruang pelayanan ?';

        $skalaOptions = [
            1 => ['label' => 'Tidak Baik',   'icon' => 'tidak baik.png'],
            2 => ['label' => 'Kurang Baik',  'icon' => 'kurang baik.png'],
            3 => ['label' => 'Baik',         'icon' => 'baik.png'],
            4 => ['label' => 'Sangat Baik',  'icon' => 'sangat baik.png'],
        ];

        $selected = session('survey.ikm.8');

        return view('survey.step15', compact('currentStep','totalSteps','progressPercent','pertanyaan','skalaOptions','selected'));
    }

    public function step15Post(Request $request)
    {
        $request->validate(['ikm_8' => 'required|integer|between:1,4']);

        $ikm = session('survey.ikm', []);
        $ikm[8] = (int) $request->ikm_8;
        session(['survey.ikm' => $ikm]);

        $sr = $this->currentResponseOrFail();
        $sr->update(['u8' => (int) $request->ikm_8]);

        return redirect()->route('survey.step16');
    }

    // ===================== STEP 16 =====================
    public function step16()
    {
        $currentStep     = 16;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        $pertanyaan = 'Bagaimana pendapat Saudara tentang kelengkapan media penanganan pengaduan atau saran/masukan yang ada dalam unit pelayanan ?';

        $skalaOptions = [
            1 => ['label' => 'Tidak Baik',   'icon' => 'tidak baik.png'],
            2 => ['label' => 'Kurang Baik',  'icon' => 'kurang baik.png'],
            3 => ['label' => 'Baik',         'icon' => 'baik.png'],
            4 => ['label' => 'Sangat Baik',  'icon' => 'sangat baik.png'],
        ];

        $selected = session('survey.ikm.9');

        return view('survey.step16', compact('currentStep','totalSteps','progressPercent','pertanyaan','skalaOptions','selected'));
    }

    public function step16Post(Request $request)
    {
        $request->validate(['ikm_9' => 'required|integer|between:1,4']);

        $ikm = session('survey.ikm', []);
        $ikm[9] = (int) $request->ikm_9;
        session(['survey.ikm' => $ikm]);

        $sr = $this->currentResponseOrFail();
        $sr->update(['u9' => (int) $request->ikm_9]);

        return redirect()->route('survey.step17');
    }

    // ===================== STEP 17 =====================
    public function step17()
    {
        $currentStep     = 17;
        $totalSteps      = $this->totalSteps;
        $progressPercent = ($currentStep / $totalSteps) * 100;

        $saran = session('survey.saran');

        return view('survey.step17', compact('currentStep', 'totalSteps', 'progressPercent', 'saran'));
    }

    public function step17Post(Request $request)
    {
        $request->validate(['saran' => 'nullable|string|max:2000']);

        $sr = $this->currentResponseOrFail();

        // hitung nilai rata-rata u1–u9
        $unsur = [
            $sr->u1, $sr->u2, $sr->u3, $sr->u4, $sr->u5,
            $sr->u6, $sr->u7, $sr->u8, $sr->u9
        ];

        // pastikan tidak ada null (jika ada, dianggap 0)
        $unsur = array_map(fn($v) => $v ?? 0, $unsur);

        $rataUnsur = array_sum($unsur) / count($unsur);

        // konversi ke IKM (skala 0–100)
        $nilaiIKM = $rataUnsur * 25;

        // update ke database
        $sr->update([
            'saran' => $request->saran,
            'completed' => true,
            'nilai_ikm' => $nilaiIKM,
        ]);

        // reset session
        session()->forget('survey');

        return redirect()->route('home')->with('success', 'Terima kasih, survei Anda sudah tersimpan.');
    }
}