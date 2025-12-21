<?php
// app/Http\Controllers/Admin/DinasLayananController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DinasLayananController extends Controller
{
    /**
     * LIST OPD & LAYANAN
     */
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q'));

        $opds = Opd::query()
            ->with(['services' => fn ($s) => $s->orderBy('nama')])
            ->when($q !== '', function ($query) use ($q) {
                $query->where('nama', 'like', "%{$q}%")
                    ->orWhere('kode', 'like', "%{$q}%")
                    ->orWhereHas('services', fn ($s) =>
                        $s->where('nama', 'like', "%{$q}%")
                    );
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        // PERBAIKAN 1: HAPUS 'id' dari SELECT karena tabel opd tidak punya kolom id
        $allOpds = Opd::orderBy('nama')->get(['kode', 'nama', 'category_id']);

        return view('admin.dinas-layanan', compact('opds', 'q', 'allOpds'));
    }

    /**
     * SIMPAN OPD BARU
     */
    public function storeOpd(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'kode'        => ['required', 'string', 'max:50', 'unique:opd,kode'],
            'nama'        => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer'],
        ]);

        Opd::create($data);

        return back()->with('success', 'OPD berhasil ditambahkan.');
    }

    /**
     * UPDATE OPD
     */
    public function updateOpd(Request $request, Opd $opd): RedirectResponse
    {
        $data = $request->validate([
            'kode'        => [
                'required',
                'string',
                'max:50',
                // PERBAIKAN 2: Ganti $opd->id dengan $opd->kode
                Rule::unique('opd', 'kode')->ignore($opd->kode, 'kode'),
            ],
            'nama'        => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer'],
        ]);

        $opd->update($data);

        return back()->with('success', 'OPD berhasil diperbarui.');
    }

    /**
     * HAPUS OPD & SEMUA LAYANANNYA
     */
    public function destroyOpd(Opd $opd): RedirectResponse
    {
        $opd->services()->delete();
        $opd->delete();

        return back()->with('success', 'OPD berhasil dihapus.');
    }

    /**
     * SIMPAN LAYANAN
     */
    public function storeLayanan(Request $request): RedirectResponse
    {
        $data = $request->validate([
            // PERBAIKAN 3: Ganti 'opd_id' dengan 'kode_opd' dan 'exists:opd,id' dengan 'exists:opd,kode'
            'kode_opd' => ['required', 'exists:opd,kode'],
            'nama'     => ['required', 'string', 'max:255'],
        ]);

        // PERBAIKAN 4: Field harus sesuai dengan nama di database (kode_opd)
        Service::create([
            'kode_opd' => $data['kode_opd'],
            'nama'     => $data['nama']
        ]);

        return back()->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * UPDATE LAYANAN
     */
    public function updateLayanan(Request $request, Service $service): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $service->update($data);

        return back()->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * HAPUS LAYANAN
     */
    public function destroyLayanan(Service $service): RedirectResponse
    {
        $service->delete();

        return back()->with('success', 'Layanan berhasil dihapus.');
    }
}