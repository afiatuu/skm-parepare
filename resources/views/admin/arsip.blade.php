@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Arsip Laporan IKM</h1>

    @if($arsip->count())
        <table class="table-auto w-full border-collapse border border-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">OPD</th>
                    <th class="border px-4 py-2">Nilai IKM</th>
                    <th class="border px-4 py-2">Total Responden</th>
                    <th class="border px-4 py-2">Tanggal Publish</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($arsip as $item)
                    <tr>
                        <td class="border px-4 py-2">{{ $no++ }}</td>
                        <td class="border px-4 py-2">{{ $item->opd_kode }}</td>
                        <td class="border px-4 py-2">{{ $item->nilai_ikm }}</td>
                        <td class="border px-4 py-2">{{ $item->total_responden }}</td>
                        <td class="border px-4 py-2">{{ $item->published_at }}</td>
                        <td class="border px-4 py-2 text-center">
                            <a href="{{ route('admin.laporan_ikm.detailArsip', $item->id) }}"
                               class="px-3 py-1 rounded-md bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-slate-500">Belum ada arsip laporan.</p>
    @endif
</div>
@endsection