@extends('layouts.app')

@section('content')
    <div class="rounded-[28px] border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-black/30 backdrop-blur-xl">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-medium text-cyan-300">Ringkasan utama</p>
                <h1 class="text-2xl font-semibold text-white">Dashboard</h1>
                <p class="mt-2 text-sm text-slate-400">Halaman dashboard untuk monitoring pengaduan masyarakat.</p>
            </div>
            <div class="rounded-full border border-cyan-400/20 bg-cyan-400/10 px-3 py-1 text-sm font-medium text-cyan-200">
                SIPENKA • Aktif
            </div>
        </div>
    </div>
@endsection
