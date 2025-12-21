{{-- resources/views/admin/partials/dinas-list.blade.php --}}
@php $brand = '#0B5394'; @endphp

{{-- PERBAIKAN: Variabel $opds bukan $dinas --}}
@forelse($opds as $opd)
    <div class="rounded-3xl border border-slate-200 overflow-hidden mt-4">
        {{-- Header OPD --}}
        <div class="bg-slate-50 px-5 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <p class="font-semibold text-slate-900">
                    {{ $opd->nama }}
                    <span class="text-xs text-slate-500 font-normal">({{ $opd->kode }})</span>
                </p>
                <p class="text-xs text-slate-500 mt-0.5">
                    Category ID: {{ $opd->category_id ?? '-' }} • Layanan: {{ $opd->services->count() }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                {{-- Edit OPD --}}
                {{-- PERBAIKAN: Ganti $d->id dengan $opd->kode --}}
                <form method="POST" action="{{ route('admin.dinas.update', $opd->kode) }}" class="flex gap-2">
                    @csrf
                    @method('PUT')
                    {{-- PERBAIKAN: Tambahkan input untuk kode --}}
                    <input type="hidden" name="kode" value="{{ $opd->kode }}">
                    <input name="nama" value="{{ $opd->nama }}" class="rounded-2xl border px-3 py-2 text-sm">
                    <button class="h-10 px-4 rounded-2xl text-sm font-semibold text-white"
                            style="background:{{ $brand }};">Simpan</button>
                </form>

                {{-- Hapus OPD --}}
                {{-- PERBAIKAN: Ganti $d->id dengan $opd->kode --}}
                <form method="POST" action="{{ route('admin.dinas.destroy', $opd->kode) }}"
                    onsubmit="return confirm('Hapus OPD ini beserta seluruh layanannya?')">
                    @csrf
                    @method('DELETE')
                    <button class="h-10 px-4 rounded-2xl border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 text-sm font-semibold">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        {{-- Layanan milik OPD ini --}}
        <div class="px-5 py-4">
            @if($opd->services->isEmpty())
                <p class="text-sm text-slate-500">Belum ada layanan.</p>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="py-2 text-left font-medium">Nama Layanan</th>
                            <th class="py-2 text-right font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($opd->services as $service)
                            <tr class="border-b border-slate-100">
                                <td class="py-3 pr-3">{{ $service->nama }}</td>
                                <td class="py-3 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        {{-- Edit Layanan --}}
                                        {{-- Service masih pakai id (ini OK) --}}
                                        <form method="POST" action="{{ route('admin.layanan.update', $service->id) }}" class="flex gap-2">
                                            @csrf
                                            @method('PUT')
                                            <input name="nama" value="{{ $service->nama }}" class="rounded-2xl border px-3 py-2 text-sm">
                                            <button class="h-9 px-3 rounded-2xl text-sm font-semibold text-white"
                                                    style="background:{{ $brand }};">Simpan</button>
                                        </form>

                                        {{-- Hapus Layanan --}}
                                        {{-- Service masih pakai id (ini OK) --}}
                                        <form method="POST" action="{{ route('admin.layanan.destroy', $service->id) }}"
                                            onsubmit="return confirm('Hapus layanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="h-9 px-3 rounded-2xl border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 text-xs font-semibold">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@empty
    <div class="rounded-2xl border border-dashed border-slate-300 p-8 text-center mt-4">
        <p class="text-sm text-slate-600">Belum ada data OPD.</p>
    </div>
@endforelse

{{-- Pagination --}}
{{-- PERBAIKAN: Ganti $dinas dengan $opds --}}
@if($opds->hasPages())
<div class="mt-6 flex justify-end items-center gap-2">
    {{-- Info total --}}
    <div class="text-sm text-slate-600 mr-4">
        Menampilkan {{ $opds->firstItem() }} - {{ $opds->lastItem() }} dari {{ $opds->total() }} OPD
    </div>
    
    {{-- Tombol Previous --}}
    @if ($opds->onFirstPage())
        <span class="px-3 py-1 border rounded text-slate-400 cursor-not-allowed">&lt;</span>
    @else
        <a href="{{ $opds->previousPageUrl() }}" 
           class="px-3 py-1 border rounded hover:bg-slate-100 pagination-link">&lt;</a>
    @endif

    {{-- Nomor halaman aktif --}}
    <span class="px-3 py-1 border rounded bg-slate-200 font-semibold">
        {{ $opds->currentPage() }}
    </span>

    {{-- Tombol Next --}}
    @if ($opds->hasMorePages())
        <a href="{{ $opds->nextPageUrl() }}" 
           class="px-3 py-1 border rounded hover:bg-slate-100 pagination-link">&gt;</a>
    @else
        <span class="px-3 py-1 border rounded text-slate-400 cursor-not-allowed">&gt;</span>
    @endif
</div>
@endif