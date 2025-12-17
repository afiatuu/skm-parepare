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