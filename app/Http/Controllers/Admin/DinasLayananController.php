<?php
// app\Http\Controllers\Admin\DinasLayananController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dinas;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DinasLayananController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q'));

        $dinas = Dinas::query()
            ->with(['services' => fn($s) => $s->orderBy('nama')])
            ->when($q !== '', function ($query) use ($q) {
                $query->where('nama', 'like', "%{$q}%")
                      ->orWhere('kode', 'like', "%{$q}%")
                      ->orWhereHas('services', fn($s) => $s->where('nama', 'like', "%{$q}%"));
            })
            ->orderBy('nama')
            ->paginate(1)
            ->withQueryString();

        $allDinas = Dinas::orderBy('nama')->get(['id','nama','kode']);
        return view('admin.dinas-layanan', compact('dinas', 'q', 'allDinas'));
    }

    public function storeDinas(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'kode' => ['required','string','max:50', 'unique:dinas,kode'],
            'nama' => ['required','string','max:255'],
            'category_id' => ['nullable','integer'],
        ]);

        Dinas::create($data);

        return back()->with('success', 'Dinas berhasil ditambahkan.');
    }

    public function updateDinas(Request $request, Dinas $dinas): RedirectResponse
    {
        $data = $request->validate([
            'kode' => ['required','string','max:50', Rule::unique('dinas','kode')->ignore($dinas->id)],
            'nama' => ['required','string','max:255'],
            'category_id' => ['nullable','integer'],
        ]);

        $dinas->update($data);

        return back()->with('success', 'Dinas berhasil diperbarui.');
    }

    public function destroyDinas(Dinas $dinas): RedirectResponse
    {
        $dinas->services()->delete();
        $dinas->delete();

        return back()->with('success', 'Dinas berhasil dihapus.');
    }

    public function storeLayanan(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'dinas_id' => ['required','exists:dinas,id'],
            'nama' => ['required','string','max:255'],
        ]);

        Service::create($data);

        return back()->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function updateLayanan(Request $request, Service $service): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required','string','max:255'],
        ]);

        $service->update($data);

        return back()->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroyLayanan(Service $service): RedirectResponse
    {
        $service->delete();
        return back()->with('success', 'Layanan berhasil dihapus.');
    }
}