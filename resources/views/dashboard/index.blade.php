@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">Total Pengaduan</p>
                <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $totalPengaduan }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">Menunggu</p>
                <p class="mt-4 text-3xl font-semibold text-amber-500">{{ $menunggu }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">Diproses</p>
                <p class="mt-4 text-3xl font-semibold text-sky-500">{{ $diproses }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">Selesai</p>
                <p class="mt-4 text-3xl font-semibold text-emerald-500">{{ $selesai }}</p>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Pengaduan Terbaru</h3>
                    <p class="mt-1 text-sm text-slate-500">Data dummy sebagai placeholder dashboard.</p>
                </div>
            </div>

            <div class="mt-6 flow-root">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nomor</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Judul</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @foreach ($latestPengaduan as $item)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-700">{{ $item['nomor'] }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-700">{{ $item['judul'] }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm">
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $item['status'] === 'menunggu' ? 'bg-amber-100 text-amber-700' : ($item['status'] === 'diproses' ? 'bg-sky-100 text-sky-700' : 'bg-emerald-100 text-emerald-700') }}">
                                                {{ ucfirst($item['status']) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
