@extends('layouts.app')

@section('content')
    <div class="rounded-[28px] border border-white/20 bg-slate-800/95 p-6 shadow-2xl shadow-black/40">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-medium text-cyan-300">Ringkasan utama</p>
                <h1 class="text-2xl font-semibold text-white">Dashboard</h1>
                <p class="mt-2 text-sm text-slate-400">Halaman dashboard untuk monitoring pengaduan masyarakat.</p>
            </div>
            <div class="rounded-full border border-cyan-400/30 bg-cyan-500/10 px-3 py-1 text-sm font-medium text-cyan-100">
                SIPENKA • Aktif
            </div>
        </div>
    </div>
@endsection
