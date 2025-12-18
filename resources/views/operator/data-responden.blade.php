@extends('layouts.operator')

@section('title', 'Data Responden - E-SKM')

@section('content')
    <section class="mb-6">
        <h1 class="text-xl md:text-2xl font-bold text-slate-900">Data Responden</h1>
        <p class="text-sm text-slate-500 mt-1">
            Daftar seluruh responden survei untuk OPD: <span class="font-semibold">{{ $opdKode }}</span>.
        </p>
    </section>

    {{-- FILTER & SEARCH --}}
    <section class="mb-4 rounded-2xl bg-white border border-slate-200 p-4 md:p-5">
        <form method="GET" action="{{ route('operator.data-responden') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Cari (Nama / No. WA)</label>
                <input type="text" name="q" value="{{ request('q') }}"
                       class="w-56 md:w-72 rounded-xl border-slate-300 text-sm"
                       placeholder="Contoh: Nur / 0853..." />
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Survei</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                       class="rounded-xl border-slate-300 text-sm" />
            </div>
            <div>
                <button class="px-4 py-2.5 rounded-2xl bg-[#0B5394] text-white text-sm font-semibold hover:opacity-95">
                    Terapkan
                </button>
            </div>
            @if(request()->has('q') || request()->has('tanggal'))
                <div>
                    <a href="{{ route('operator.data-responden') }}"
                       class="text-xs text-slate-500 underline">Reset filter</a>
                </div>
            @endif

            <div class="ml-auto text-sm text-slate-500">
                Total responden: <span class="font-semibold text-slate-700">{{ $totalResponden }}</span>
            </div>
        </form>
    </section>
    {{-- FORM INPUT RESPONDEN --}}
    <section class="mb-6 rounded-2xl bg-white border border-slate-200 p-4 md:p-5">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">Tambah Responden Baru</h2>
        <form action="{{ route('operator.data-responden.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Nama</label>
                <input type="text" name="nama" class="w-full rounded-xl border-slate-300 text-sm" required>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">No. WA</label>
                <input type="text" name="no_wa" class="w-full rounded-xl border-slate-300 text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Gender</label>
                <select name="gender" class="w-full rounded-xl border-slate-300 text-sm">
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Usia</label>
                <input type="number" name="usia" class="w-full rounded-xl border-slate-300 text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Pendidikan</label>
                <input type="text" name="pendidikan" class="w-full rounded-xl border-slate-300 text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Pekerjaan</label>
                <input type="text" name="pekerjaan" class="w-full rounded-xl border-slate-300 text-sm">
            </div>

            {{-- Input unsur u1..u9 --}}
            @for($i=1; $i<=9; $i++)
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">U{{ $i }}</label>
                    <select name="u{{ $i }}" class="w-full rounded-xl border-slate-300 text-sm" required>
                        <option value="">-- Pilih --</option>
                        <option value="1">1 - Sangat Tidak Puas</option>
                        <option value="2">2 - Tidak Puas</option>
                        <option value="3">3 - Puas</option>
                        <option value="4">4 - Sangat Puas</option>
                    </select>
                </div>
            @endfor

            <div class="md:col-span-2">
                <button type="submit" class="px-4 py-2.5 rounded-2xl bg-[#0B5394] text-white text-sm font-semibold hover:opacity-95">
                    Simpan Responden
                </button>
            </div>
        </form>
    </section>

    {{-- TABLE --}}
    <section class="rounded-2xl bg-white border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                <tr class="text-left text-slate-600">
                    <th class="px-6 py-3 font-semibold">Waktu</th>
                    <th class="px-6 py-3 font-semibold">Nama</th>
                    <th class="px-6 py-3 font-semibold">No. WA</th>
                    <th class="px-6 py-3 font-semibold">Gender</th>
                    <th class="px-6 py-3 font-semibold">Usia</th>
                    <th class="px-6 py-3 font-semibold">Pendidikan</th>
                    <th class="px-6 py-3 font-semibold">Pekerjaan</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse($responses as $r)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3 text-slate-600">{{ $r->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-3 font-semibold text-slate-900">{{ $r->nama ?? '-' }}</td>
                        <td class="px-6 py-3 text-slate-700">{{ $r->no_wa ?? '-' }}</td>
                        <td class="px-6 py-3 text-slate-700">{{ $r->gender ?? '-' }}</td>
                        <td class="px-6 py-3 text-slate-700">{{ $r->usia ?? '-' }}</td>
                        <td class="px-6 py-3 text-slate-700">{{ $r->pendidikan ?? '-' }}</td>
                        <td class="px-6 py-3 text-slate-700">{{ $r->pekerjaan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                            Belum ada data responden untuk filter yang dipilih.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $responses->links() }}
        </div>
    </section>
@endsection