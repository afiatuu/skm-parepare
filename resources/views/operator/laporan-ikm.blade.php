@extends('layouts.operator')

@section('title', 'Laporan IKM - E-SKM')

@section('content')
    <section class="mb-6">
        <h1 class="text-xl md:text-2xl font-bold text-slate-900">Laporan IKM</h1>
        <p class="text-sm text-slate-500 mt-1">
            Rekap nilai Indeks Kepuasan Masyarakat untuk OPD: <span class="font-semibold">{{ $opdKode }}</span>.
        </p>
    </section>

    {{-- RINGKASAN --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="rounded-2xl bg-white border border-slate-200 p-6">
            <div class="text-xs text-slate-500 uppercase tracking-wider">Rata-Rata IKM</div>
            <div class="mt-2 text-3xl font-extrabold text-primary">{{ number_format($ikmRata, 2, ',', '.') }}</div>
            <div class="mt-1 text-sm text-slate-500">Skala 1–100</div>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200 p-6">
            <div class="text-xs text-slate-500 uppercase tracking-wider">Total Responden</div>
            <div class="mt-2 text-3xl font-extrabold text-slate-900">{{ $totalResponden }}</div>
            <div class="mt-1 text-sm text-slate-500">Semua periode</div>
        </div>
        <div class="rounded-2xl bg-white border border-dashed border-slate-300 p-6 flex items-center">
            <p class="text-sm text-slate-500">
                Grafik tren IKM per bulan dan radar unsur ditampilkan di bawah.
            </p>
        </div>
    </section>

    {{-- TABEL UNSUR --}}
    <section class="rounded-2xl bg-white border border-slate-200 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="text-base font-semibold text-slate-900">Rincian Nilai per Unsur</div>
            <div class="text-sm text-slate-500">Nilai 1–4 dikonversi ke skala 25–100</div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                <tr class="text-left text-slate-600">
                    <th class="px-6 py-3 font-semibold">Kode</th>
                    <th class="px-6 py-3 font-semibold">Unsur Pelayanan</th>
                    <th class="px-6 py-3 font-semibold">Rata-rata (1–4)</th>
                    <th class="px-6 py-3 font-semibold">IKM Unsur (25–100)</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse($unsurData as $u)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3 font-semibold text-slate-900">{{ $u['kode'] }}</td>
                        <td class="px-6 py-3 text-slate-800">{{ $u['nama'] }}</td>
                        <td class="px-6 py-3 text-slate-700">{{ number_format($u['nilai'], 2, ',', '.') }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary font-semibold">
                                {{ number_format($u['ikm'], 2, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                            Belum ada data IKM yang dapat dihitung untuk OPD ini.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- GRAFIK TREN PER BULAN --}}
    <section class="rounded-2xl bg-white border border-slate-200 p-6 mb-8">
        <h3 class="text-base font-semibold text-slate-900 mb-4">Grafik Tren IKM per Bulan</h3>
        <canvas id="ikmTrendChart" height="120"></canvas>
    </section>

    {{-- GRAFIK RADAR PER UNSUR --}}
    <section class="rounded-2xl bg-white border border-slate-200 p-6">
        <h3 class="text-base font-semibold text-slate-900 mb-4">Grafik Radar Unsur Pelayanan</h3>
        <canvas id="ikmRadarChart" height="120"></canvas>
    </section>

    {{-- SCRIPT CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Grafik Tren IKM per Bulan
        const ctxTrend = document.getElementById('ikmTrendChart').getContext('2d');
        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: @json($trendData->pluck('bulan')),
                datasets: [{
                    label: 'Nilai IKM',
                    data: @json($trendData->pluck('ikm')),
                    borderColor: '#0B5394',
                    backgroundColor: '#0B5394',
                    tension: 0.3,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        // Grafik Radar Unsur Pelayanan
        const ctxRadar = document.getElementById('ikmRadarChart').getContext('2d');
        new Chart(ctxRadar, {
            type: 'radar',
            data: {
                labels: @json($unsurData->pluck('nama')),
                datasets: [{
                    label: 'IKM Unsur',
                    data: @json($unsurData->pluck('ikm')),
                    backgroundColor: 'rgba(11, 83, 148, 0.2)',
                    borderColor: '#0B5394',
                    pointBackgroundColor: '#0B5394'
                }]
            },
            options: {
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
@endsection