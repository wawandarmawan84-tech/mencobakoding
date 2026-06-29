@extends('layouts.app')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        {{-- Card: Total Pengaduan --}}
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-medium text-slate-500">Total Pengaduan</p>
            <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $totalPengaduan }}</p>
        </div>

        {{-- Card: Menunggu --}}
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-medium text-slate-500">Menunggu</p>
            <p class="mt-4 text-3xl font-semibold text-amber-500">{{ $menunggu }}</p>
        </div>

        {{-- Card: Diproses --}}
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-medium text-slate-500">Diproses</p>
            <p class="mt-4 text-3xl font-semibold text-sky-500">{{ $diproses }}</p>
        </div>

        {{-- Card: Selesai --}}
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-medium text-slate-500">Selesai</p>
            <p class="mt-4 text-3xl font-semibold text-emerald-500">{{ $selesai }}</p>
        </div>
    </div>
@endsection
