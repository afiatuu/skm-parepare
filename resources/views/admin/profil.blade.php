@extends('layouts.admin')

@section('page_title', 'Profil Akun')
@section('page_subtitle', 'Kelola informasi akun admin')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm max-w-2xl mx-auto">
    <h2 class="text-xl font-bold text-slate-900 mb-2">Profil Akun</h2>
    <p class="text-sm text-slate-500 mb-6">Perbarui informasi akun Anda untuk menjaga keamanan dan konsistensi sistem.</p>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.profil.update') }}" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full h-11 rounded-2xl border px-4 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30">
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full h-11 rounded-2xl border px-4 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30">
        </div>

        {{-- Password --}}
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                <input type="password" name="password"
                       class="w-full h-11 rounded-2xl border px-4 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full h-11 rounded-2xl border px-4 text-sm outline-none focus:ring-2 focus:ring-[#0B5394]/30">
            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex items-center gap-3">
            <button class="h-11 px-6 rounded-2xl text-sm font-semibold text-white shadow-sm hover:opacity-95 transition"
                    style="background:#0B5394;">
                Simpan Perubahan
            </button>
            <button type="reset"
                    class="h-11 px-6 rounded-2xl text-sm font-semibold text-slate-700 border border-slate-300 hover:bg-slate-50 transition">
                Reset
            </button>
        </div>
    </form>
</div>
@endsection