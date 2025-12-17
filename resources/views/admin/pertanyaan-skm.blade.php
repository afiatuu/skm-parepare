@extends('layouts.admin')

@section('title', 'Pertanyaan SKM')
@section('page_title', 'Pertanyaan SKM')
@section('page_subtitle', 'Kelola daftar pertanyaan berdasarkan 9 unsur SKM')

@section('content')
@php $brand = '#0B5394'; @endphp

<div class="space-y-6">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
        <div class="pl-4">
            <h2 class="text-lg font-bold text-slate-900">
                Manajemen Pertanyaan SKM
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Tambah, edit, aktif/nonaktifkan, dan urutkan pertanyaan.
            </p>
        </div>

        {{-- Form filter --}}
        <form method="GET" class="mt-4 flex flex-wrap md:flex-nowrap gap-3 md:items-center">
            <select name="unsur"
                class="h-11 rounded-2xl border border-slate-200 px-4 text-sm bg-white focus:ring-2 focus:ring-[#0B5394]/30">
                <option value="">Semua Unsur</option>
                @foreach($unsurList as $k => $label)
                    <option value="{{ $k }}" @selected((string)$unsur === (string)$k)>
                        Unsur {{ $k }} — {{ $label }}
                    </option>
                @endforeach
            </select>

            <input name="q" value="{{ $q ?? '' }}"
                class="h-11 w-72 rounded-2xl border border-slate-200 px-4 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30"
                placeholder="Cari kode / pertanyaan...">

            <button
                class="h-11 px-6 rounded-2xl text-sm font-semibold text-white shadow-sm hover:opacity-95 transition"
                style="background:{{ $brand }};">
                Cari
            </button>
        </form>
    </div>

    {{-- Form tambah --}}
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
        <h3 class="font-semibold text-slate-900">Tambah Pertanyaan</h3>

        <form method="POST" action="{{ route('admin.pertanyaan_skm.store') }}" class="mt-4 grid grid-cols-1 lg:grid-cols-12 gap-3">
            @csrf

            <div class="lg:col-span-3">
                <label class="text-xs text-slate-500">Unsur</label>
                <select name="unsur" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm bg-white">
                    @foreach($unsurList as $k => $label)
                        <option value="{{ $k }}" @selected(old('unsur')==$k)>
                            {{ $k }} — {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('unsur') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="lg:col-span-2">
                <label class="text-xs text-slate-500">Kode (opsional)</label>
                <input name="kode" value="{{ old('kode') }}"
                       class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm"
                       placeholder="U1, U2...">
                @error('kode') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="lg:col-span-2">
                <label class="text-xs text-slate-500">Urutan</label>
                <input type="number" name="urutan" value="{{ old('urutan', 1) }}"
                       class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm" min="1">
                @error('urutan') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="lg:col-span-5">
                <label class="text-xs text-slate-500">Pertanyaan</label>
                <input name="pertanyaan" value="{{ old('pertanyaan') }}"
                       class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm"
                       placeholder="Tulis pertanyaan SKM...">
                @error('pertanyaan') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="lg:col-span-12 flex items-center justify-between mt-2">
                <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true)) class="rounded border-slate-300">
                    Aktif
                </label>

                <button class="h-11 px-5 rounded-2xl text-sm font-semibold text-white shadow-sm hover:opacity-95"
                        style="background:{{ $brand }};">
                    + Simpan Pertanyaan
                </button>
            </div>
        </form>
    </div>

    {{-- List --}}
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-center justify-between gap-3">
            <h3 class="font-semibold text-slate-900">Daftar Pertanyaan</h3>
            <div class="text-xs text-slate-500">Total: {{ $questions->total() }}</div>
        </div>

        <div class="mt-4 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-slate-500">
                    <tr class="border-b border-slate-200">
                        <th class="py-2 text-left font-medium">Unsur</th>
                        <th class="py-2 text-left font-medium">Kode</th>
                        <th class="py-2 text-left font-medium">Urutan</th>
                        <th class="py-2 text-left font-medium">Pertanyaan</th>
                        <th class="py-2 text-center font-medium">Aktif</th>
                        <th class="py-2 text-right font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($questions as $row)
                        <tr class="border-b border-slate-100 align-top">
                            <td class="py-3 pr-3">
                                <div class="font-semibold text-slate-900">{{ $row->unsur }}</div>
                                <div class="text-xs text-slate-500">{{ $unsurList[$row->unsur] ?? '-' }}</div>
                            </td>
                            <td class="py-3 pr-3 text-slate-700">{{ $row->kode ?? '-' }}</td>
                            <td class="py-3 pr-3 text-slate-700">{{ $row->urutan }}</td>
                            <td class="py-3 pr-3 text-slate-900">{{ $row->pertanyaan }}</td>
                            <td class="py-3 text-center">
                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $row->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                    {{ $row->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <details>
                                        <summary class="list-none cursor-pointer h-9 px-3 rounded-2xl border border-slate-200 bg-white hover:bg-slate-100 text-xs inline-flex items-center">
                                            Edit
                                        </summary>
                                        <div class="mt-2 p-4 rounded-2xl border border-slate-200 bg-white w-[520px] max-w-[90vw]">
                                            <form method="POST" action="{{ route('admin.pertanyaan_skm.update', $row->id) }}" class="space-y-3">
                                                @csrf
                                                @method('PUT')

                                                <div class="grid grid-cols-12 gap-2">
                                                    <div class="col-span-4">
                                                        <label class="text-xs text-slate-500">Unsur</label>
                                                        <select name="unsur" class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm bg-white">
                                                            @foreach($unsurList as $k => $label)
                                                                <option value="{{ $k }}" @selected($row->unsur==$k)>{{ $k }} — {{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-span-4">
                                                        <label class="text-xs text-slate-500">Kode</label>
                                                        <input name="kode" value="{{ $row->kode }}"
                                                               class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm">
                                                    </div>

                                                    <div class="col-span-4">
                                                        <label class="text-xs text-slate-500">Urutan</label>
                                                        <input type="number" name="urutan" value="{{ $row->urutan }}"
                                                               class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" min="1">
                                                    </div>
                                                </div>

                                                <div>
                                                    <label class="text-xs text-slate-500">Pertanyaan</label>
                                                    <textarea name="pertanyaan" rows="3"
                                                              class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm">{{ $row->pertanyaan }}</textarea>
                                                </div>

                                                <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                                    <input type="checkbox" name="is_active" value="1" @checked($row->is_active) class="rounded border-slate-300">
                                                    Aktif
                                                </label>

                                                <div class="flex gap-2">
                                                    <button class="h-10 px-4 rounded-2xl text-sm font-semibold text-white"
                                                            style="background:{{ $brand }};">
                                                        Simpan
                                                    </button>
                                                    <span class="text-xs text-slate-500 self-center">Tersimpan tanpa pindah halaman.</span>
                                                </div>
                                            </form>
                                        </div>
                                    </details>

                                    <form method="POST" action="{{ route('admin.pertanyaan_skm.destroy', $row->id) }}"
                                          onsubmit="return confirm('Hapus pertanyaan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="h-9 px-3 rounded-2xl border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 text-xs font-semibold">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-500">
                                Belum ada pertanyaan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $questions->links() }}
        </div>
    </div>
</div>
@endsection