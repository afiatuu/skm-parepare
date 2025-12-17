<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveyQuestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PertanyaanSkmController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q'));
        $unsur = $request->query('unsur'); // optional filter

        $questions = SurveyQuestion::query()
            ->when($unsur, fn($query) => $query->where('unsur', (int) $unsur))
            ->when($q !== '', function ($query) use ($q) {
                $query->where('pertanyaan', 'like', "%{$q}%")
                      ->orWhere('kode', 'like', "%{$q}%");
            })
            ->orderBy('unsur')
            ->orderBy('urutan')
            ->paginate(15)
            ->withQueryString();

        $unsurList = [
            1 => 'Persyaratan',
            2 => 'Sistem, Mekanisme, dan Prosedur',
            3 => 'Waktu Penyelesaian',
            4 => 'Biaya/Tarif',
            5 => 'Produk Spesifikasi Jenis Pelayanan',
            6 => 'Kompetensi Pelaksana',
            7 => 'Perilaku Pelaksana',
            8 => 'Penanganan Pengaduan, Saran, dan Masukan',
            9 => 'Sarana dan Prasarana',
        ];

        return view('admin.pertanyaan-skm', compact('questions', 'q', 'unsur', 'unsurList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'unsur' => ['required','integer','between:1,9'],
            'kode' => ['nullable','string','max:20'],
            'pertanyaan' => ['required','string','max:2000'],
            'urutan' => ['required','integer','min:1','max:9999'],
            'is_active' => ['nullable','boolean'],
        ]);

        $data['is_active'] = (bool) ($request->boolean('is_active'));

        SurveyQuestion::create($data);

        return back()->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function update(Request $request, SurveyQuestion $question): RedirectResponse
    {
        $data = $request->validate([
            'unsur' => ['required','integer','between:1,9'],
            'kode' => ['nullable','string','max:20'],
            'pertanyaan' => ['required','string','max:2000'],
            'urutan' => ['required','integer','min:1','max:9999'],
            'is_active' => ['nullable','boolean'],
        ]);

        $data['is_active'] = (bool) ($request->boolean('is_active'));

        $question->update($data);

        return back()->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroy(SurveyQuestion $question): RedirectResponse
    {
        $question->delete();
        return back()->with('success', 'Pertanyaan berhasil dihapus.');
    }
}