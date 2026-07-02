@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl">
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm font-medium text-cyan-300">Pengaduan masuk</p>
            <h1 class="text-2xl font-semibold text-white">Pengaduan Masuk</h1>
            <p class="mt-1 text-sm text-slate-400">Daftar pengaduan untuk petugas dengan filter prioritas.</p>
        </div>
        <a href="{{ route('pengaduan.index') }}" class="text-sm text-cyan-300 hover:text-cyan-200">Daftar Pengaduan Warga</a>
    </div>

    <form method="GET" action="{{ route('pengaduan.masuk') }}" class="mb-4 flex flex-wrap items-end gap-3 rounded-[24px] border border-white/10 bg-slate-900/70 p-4 shadow-lg shadow-black/20 backdrop-blur-xl">
        <div>
            <label for="prioritas" class="block text-sm text-slate-300">Filter Prioritas</label>
            <select id="prioritas" name="prioritas" class="mt-1 block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2 text-sm text-white">
                <option value="">Semua</option>
                <option value="darurat" {{ request('prioritas') === 'darurat' ? 'selected' : '' }}>Darurat</option>
                <option value="tinggi" {{ request('prioritas') === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                <option value="normal" {{ request('prioritas') === 'normal' ? 'selected' : '' }}>Normal</option>
                <option value="rendah" {{ request('prioritas') === 'rendah' ? 'selected' : '' }}>Rendah</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="inline-flex items-center rounded-full bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">Terapkan</button>
            <a href="{{ route('pengaduan.masuk') }}" class="inline-flex items-center rounded-full border border-white/10 px-3 py-2 text-sm text-slate-300 hover:text-white">Reset</a>
        </div>
    </form>

    <div class="overflow-hidden rounded-[24px] border border-white/10 bg-slate-900/70 shadow-2xl shadow-black/20 backdrop-blur-xl">
        <table class="min-w-full divide-y divide-white/10">
            <thead class="bg-slate-800/80 text-slate-300">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium">Nomor</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Judul</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Prioritas</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Pengadu</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Tanggal</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10 text-slate-200">
                @forelse($pengaduans as $pengaduan)
                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $pengaduan->nomor_aduan }}</td>
                        <td class="px-4 py-3 text-sm">{{ $pengaduan->judul }}</td>
                        <td class="px-4 py-3 text-sm">{{ ucfirst($pengaduan->prioritas) }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $pengaduan->status === 'menunggu' ? 'bg-amber-400/15 text-amber-300' : 'bg-cyan-400/15 text-cyan-300' }}">
                                {{ ucfirst($pengaduan->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ optional($pengaduan->user)->name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $pengaduan->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('pengaduan.show', $pengaduan) }}" class="text-cyan-300 hover:text-cyan-200">Lihat</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-400">Tidak ada pengaduan masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="border-t border-white/10 bg-slate-800/60 p-4">
            {{ $pengaduans->links() }}
        </div>
    </div>
</div>
@endsection
