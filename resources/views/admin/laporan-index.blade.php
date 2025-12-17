@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Daftar Laporan IKM</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>OPD</th>
                <th>Jumlah Responden</th>
                <th>Nilai IKM</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($laporan as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->opd_nama }}</td>
                    <td>{{ $row->jumlah_responden }}</td>
                    <td>{{ number_format($row->nilai_ikm, 2, ',', '.') }}</td>
                    <td>
                        @if($row->status == 'draft')
                            <span class="badge bg-secondary">Draft</span>
                        @elseif($row->status == 'waiting_approval')
                            <span class="badge bg-info">Menunggu Persetujuan</span>
                        @elseif($row->status == 'approved')
                            <span class="badge bg-success">Disetujui</span>
                        @elseif($row->status == 'published')
                            <span class="badge bg-primary">Dipublikasikan</span>
                        @endif
                    </td>
                    <td>
                        {{-- Tombol aksi sesuai status dan role --}}
                        @if($row->status == 'draft')
                            <form action="{{ route('admin.laporan_ikm.kirim', $row->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">Kirim</button>
                            </form>
                        @elseif($row->status == 'waiting_approval' && Auth::user()->role == 'kepala')
                            <form action="{{ route('admin.laporan_ikm.approve', $row->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                            </form>
                        @elseif($row->status == 'approved' && Auth::user()->role == 'admin')
                            <form action="{{ route('admin.laporan_ikm.publish', $row->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Publish</button>
                            </form>
                        @endif

                        {{-- Tombol detail selalu ada --}}
                        <a href="{{ route('admin.laporan_ikm.detail', $row->opd_kode) }}" class="btn btn-info btn-sm">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection