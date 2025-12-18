{{-- resources/views/admin/partials/dinas-list.blade.php --}}
@php $brand = '#0B5394'; @endphp

{{-- List OPD --}}
<div class="mt-4 space-y-4">
    @forelse($dinas as $d)
        <div class="rounded-3xl border border-slate-200 overflow-hidden">
            {{-- Header OPD --}}
            <div class="bg-slate-50 px-5 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <p class="font-semibold text-slate-900">
                        {{ $d->nama }}
                        <span class="text-xs text-slate-500 font-normal">({{ $d->kode }})</span>
                    </p>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Category ID: {{ $d->category_id ?? '-' }} • Layanan: {{ $d->services->count() }}
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    {{-- Edit OPD --}}
                    <form method="POST" action="{{ route('admin.dinas.update', $d->id) }}" class="flex gap-2">
                        @csrf
                        @method('PUT')
                        <input name="nama" value="{{ $d->nama }}" class="rounded-2xl border px-3 py-2 text-sm">
                        <button class="h-10 px-4 rounded-2xl text-sm font-semibold text-white"
                                style="background:{{ $brand }};">Simpan</button>
                    </form>

                    {{-- Hapus OPD --}}
                    <form method="POST" action="{{ route('admin.dinas.destroy', $d->id) }}"
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
                @if($d->services->isEmpty())
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
                            @foreach($d->services as $s)
                                <tr class="border-b border-slate-100">
                                    <td class="py-3 pr-3">{{ $s->nama }}</td>
                                    <td class="py-3 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            {{-- Edit Layanan --}}
                                            <form method="POST" action="{{ route('admin.layanan.update', $s->id) }}" class="flex gap-2">
                                                @csrf
                                                @method('PUT')
                                                <input name="nama" value="{{ $s->nama }}" class="rounded-2xl border px-3 py-2 text-sm">
                                                <button class="h-9 px-3 rounded-2xl text-sm font-semibold text-white"
                                                        style="background:{{ $brand }};">Simpan</button>
                                            </form>

                                            {{-- Hapus Layanan --}}
                                            <form method="POST" action="{{ route('admin.layanan.destroy', $s->id) }}"
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
        <div class="rounded-2xl border border-dashed border-slate-300 p-8 text-center">
            <p class="text-sm text-slate-600">Belum ada data OPD.</p>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($dinas->hasPages())
<div class="mt-6 flex justify-end items-center gap-2">
    {{-- Info total --}}
    <div class="text-sm text-slate-600 mr-4">
        Menampilkan {{ $dinas->firstItem() }} - {{ $dinas->lastItem() }} dari {{ $dinas->total() }} OPD
    </div>
    
    {{-- Tombol Previous --}}
    @if ($dinas->onFirstPage())
        <span class="px-3 py-1 border rounded text-slate-400 cursor-not-allowed">&lt;</span>
    @else
        <a href="{{ $dinas->previousPageUrl() }}" 
           class="px-3 py-1 border rounded hover:bg-slate-100 pagination-link">&lt;</a>
    @endif

    {{-- Nomor halaman aktif --}}
    <span class="px-3 py-1 border rounded bg-slate-200 font-semibold">
        {{ $dinas->currentPage() }}
    </span>

    {{-- Tombol Next --}}
    @if ($dinas->hasMorePages())
        <a href="{{ $dinas->nextPageUrl() }}" 
           class="px-3 py-1 border rounded hover:bg-slate-100 pagination-link">&gt;</a>
    @else
        <span class="px-3 py-1 border rounded text-slate-400 cursor-not-allowed">&gt;</span>
    @endif
</div>
@endif