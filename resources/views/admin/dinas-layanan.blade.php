@extends('layouts.admin')
{{-- resources\views\admin\dinas-layanan.blade.php --}}

@section('title', 'Data OPD & Layanan')
@section('page_title', 'Data OPD & Layanan')
@section('page_subtitle', 'Kelola daftar OPD (Dinas, RSUD, Kecamatan) dan layanan yang tersedia')

@section('content')
@php $brand = '#0B5394'; @endphp

{{-- Container utama dengan Alpine.js --}}
<div x-data="ajaxPagination" x-init="init()">
    <div class="space-y-6">

        
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl">
                    {{ session('success') }}
                </div>
            @endif
        
            {{-- Header + Search --}}
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Manajemen OPD & Layanan</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Tambah OPD (Dinas, RSUD, Kecamatan) dan layanan, edit cepat, dan hapus data.
                        </p>
                    </div>
        
                    {{-- Form search TETAP NORMAL --}}
                    <form method="GET" action="{{ route('admin.dinas_layanan') }}" class="flex items-center gap-2">
                        <input name="q" value="{{ $q ?? '' }}"
                               class="h-11 w-64 rounded-2xl border border-slate-200 px-4 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30"
                               placeholder="Cari OPD / kode / layanan...">
                        <button type="submit"
                                class="h-11 px-4 rounded-2xl text-sm font-semibold text-white shadow-sm hover:opacity-95"
                                style="background:{{ $brand }};">
                            Cari
                        </button>
                    </form>
                </div>
            </div>
        
            {{-- Form tambah OPD + tambah layanan --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                {{-- Form tambah OPD --}}
                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                    <h3 class="font-semibold text-slate-900">Tambah OPD</h3>
                    <form method="POST" action="{{ route('admin.dinas.store') }}" class="mt-4 space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="text-xs text-slate-500">Kode</label>
                                <input name="kode" value="{{ old('kode') }}"
                                    class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30"
                                    placeholder="mis: dukcapil">
                                @error('kode') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-xs text-slate-500">Nama OPD</label>
                                <input name="nama" value="{{ old('nama') }}"
                                    class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30"
                                    placeholder="Nama OPD...">
                                @error('nama') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
        
                        <div>
                            <label class="text-xs text-slate-500">Category ID (opsional)</label>
                            <input type="number" name="category_id" value="{{ old('category_id') }}"
                                class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30"
                                placeholder="1 = Dinas, 2 = RSUD, 3 = Kecamatan">
                            @error('category_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
        
                        <button class="h-11 px-5 rounded-2xl text-sm font-semibold text-white shadow-sm hover:opacity-95"
                                style="background:{{ $brand }};">
                            + Simpan OPD
                        </button>
                    </form>
                </div>
        
                {{-- Form tambah layanan --}}
                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                    <h3 class="font-semibold text-slate-900">Tambah Layanan</h3>
                    <form method="POST" action="{{ route('admin.layanan.store') }}" class="mt-4 space-y-3">
                        @csrf
        
                        <div>
                            <label class="text-xs text-slate-500">Pilih OPD</label>
                            <select name="dinas_id"
                                    class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm bg-white outline-none focus:ring-2 focus:ring-[#0B5394]/30">
                                <option value="">-- pilih OPD --</option>
                                @foreach($allDinas as $d)
                                    <option value="{{ $d->id }}" @selected(old('dinas_id') == $d->id)>
                                        {{ $d->nama }} ({{ $d->kode }})
                                    </option>
                                @endforeach
                            </select>
        
                            @error('dinas_id')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
        
                        <div>
                            <label class="text-xs text-slate-500">Nama Layanan</label>
                            <input name="nama" value="{{ old('nama') }}"
                                class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30"
                                placeholder="mis: Pembuatan KTP...">
                            @error('nama') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
        
                        <button class="h-11 px-5 rounded-2xl text-sm font-semibold text-white shadow-sm hover:opacity-95"
                                style="background:{{ $brand }};">
                            + Simpan Layanan
                        </button>
                    </form>
                </div>
            </div>
        
            {{-- Container untuk list OPD --}}
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <h3 class="font-semibold text-slate-900">Daftar OPD & Layanan</h3>
                    <div class="text-xs text-slate-500" id="total-opd">
                        Total: {{ $dinas->total() }} OPD
                    </div>
                </div>
        
                {{-- Container untuk partial list --}}
                <div id="dinas-list-container">
                    @include('admin.partials.dinas-list', ['dinas' => $dinas, 'q' => $q, 'allDinas' => $allDinas])
                </div>
            </div>
        </div>
        
        {{-- JavaScript Khusus Pagination AJAX --}}
        <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('ajaxPagination', () => ({
                init() {
                    // Event delegation untuk klik pagination link
                    document.addEventListener('click', (e) => {
                        if (e.target.classList.contains('pagination-link')) {
                            e.preventDefault();
                            this.loadPage(e.target.href);
                        }
                    });
                    
                    // Handle browser back/forward buttons
                    window.addEventListener('popstate', (e) => {
                        if (e.state && e.state.pageUrl) {
                            this.loadPage(e.state.pageUrl, false); // false = tidak pushState lagi
                        }
                    });
                },
                
                async loadPage(url, pushState = true) {
                    try {
                        // Tampilkan loading indicator sederhana
                        const container = document.getElementById('dinas-list-container');
                        const oldContent = container.innerHTML;
                        container.innerHTML = `
                            <div class="py-8 text-center">
                                <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
                                <p class="mt-2 text-sm text-slate-500">Memuat data...</p>
                            </div>
                        `;
                        
                        // Fetch halaman baru
                        const response = await fetch(url);
                        const html = await response.text();
                        
                        // Parse HTML response
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        // Extract bagian yang dibutuhkan dari halaman full
                        const newListContainer = doc.getElementById('dinas-list-container');
                        const newTotal = doc.getElementById('total-opd') || 
                                         doc.querySelector('[x-text*="Total"]') || 
                                         doc.querySelector('.text-xs.text-slate-500');
                        
                        if (newListContainer) {
                            // Update container dengan konten baru
                            container.innerHTML = newListContainer.innerHTML;
                            
                            // Update total OPD jika ada
                            if (newTotal) {
                                const currentTotal = document.getElementById('total-opd');
                                if (currentTotal) {
                                    currentTotal.innerHTML = newTotal.innerHTML;
                                }
                            }
                            
                            // Update URL di browser (tanpa reload)
                            if (pushState) {
                                window.history.pushState({ pageUrl: url }, '', url);
                            }
                            
                            // Scroll ke posisi container (tetap di tempat)
                            container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        } else {
                            // Fallback: reload halaman jika parsing gagal
                            container.innerHTML = oldContent;
                            window.location.href = url;
                        }
                        
                    } catch (error) {
                        console.error('Error loading page:', error);
                        // Fallback ke reload halaman normal
                        window.location.href = url;
                    }
                }
            }));
        });
        </script>
    </div>
@endsection