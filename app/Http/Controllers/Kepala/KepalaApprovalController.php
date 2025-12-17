<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\LaporanIkm;

class KepalaApprovalController extends Controller
{
    public function approve($id)
    {
        $laporan = LaporanIkm::findOrFail($id);

        // Validasi: hanya Kepala OPD dengan opd_kode yang sama
        if (auth()->user()->opd_kode !== $laporan->opd_kode) {
            abort(403, 'Anda tidak berwenang menyetujui laporan ini.');
        }

        $laporan->update([
            'status' => 'approved',
            'approved_by_kepala' => true,
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil disetujui.');
    }
}