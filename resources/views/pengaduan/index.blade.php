@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl space-y-5">
    <div class="rounded-[28px] border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-black/30 backdrop-blur-xl">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-medium text-cyan-300">Daftar laporan Anda</p>
                <h1 class="text-2xl font-semibold text-white">Daftar Pengaduan Saya</h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('pengaduan.create') }}" class="inline-flex items-center rounded-full bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">Buat Pengaduan Baru</a>
                <a href="/" class="text-sm text-slate-300 hover:text-white">Kembali</a>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('pengaduan.index') }}" class="flex flex-wrap gap-3 rounded-[24px] border border-white/10 bg-slate-900/70 p-4 shadow-lg shadow-black/20 backdrop-blur-xl">
        <div>
            <label class="block text-sm text-slate-300">Status</label>
            <select name="status" class="mt-1 block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2 text-sm text-white">
                <option value="">Semua</option>
                <option value="menunggu" {{ request('status')=='menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="diproses" {{ request('status')=='diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ request('status')=='selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="ditolak" {{ request('status')=='ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <div>
            <label class="block text-sm text-slate-300">Kategori</label>
            <select name="kategori_id" class="mt-1 block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2 text-sm text-white">
                <option value="">Semua</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}" {{ (string)request('kategori_id') === (string)$kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div class="self-end">
            <button type="submit" class="inline-flex items-center rounded-full bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">Filter</button>
            <a href="{{ route('pengaduan.index') }}" class="ml-2 inline-flex items-center rounded-full border border-white/10 px-3 py-2 text-sm text-slate-300 hover:text-white">Reset</a>
        </div>
    </form>

    <div class="overflow-hidden rounded-[24px] border border-white/10 bg-slate-900/70 shadow-2xl shadow-black/20 backdrop-blur-xl">
        <table class="min-w-full divide-y divide-white/10">
            <thead class="bg-slate-800/80 text-slate-300">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium">Nomor</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Judul</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Kategori</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Prioritas</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Tanggal</th>
                    @if(optional(auth()->user())->isAdmin())
                        <th class="px-4 py-3 text-left text-sm font-medium">Petugas</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Aksi</th>
                    @else
                        <th class="px-4 py-3 text-left text-sm font-medium">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10 text-slate-200">
                @forelse($pengaduans as $p)
                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $p->nomor_aduan }}</td>
                        <td class="px-4 py-3 text-sm">{{ $p->judul }}</td>
                        <td class="px-4 py-3 text-sm">{{ optional($p->kategori)->nama_kategori }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($p->status === 'menunggu')
                                <span class="rounded-full bg-amber-400/15 px-2.5 py-1 text-xs font-semibold text-amber-300">Menunggu</span>
                            @elseif($p->status === 'diproses')
                                <span class="rounded-full bg-cyan-400/15 px-2.5 py-1 text-xs font-semibold text-cyan-300">Diproses</span>
                            @elseif($p->status === 'selesai')
                                <span class="rounded-full bg-emerald-400/15 px-2.5 py-1 text-xs font-semibold text-emerald-300">Selesai</span>
                            @elseif($p->status === 'ditolak')
                                <span class="rounded-full bg-rose-400/15 px-2.5 py-1 text-xs font-semibold text-rose-300">Ditolak</span>
                            @else
                                <span class="rounded-full bg-slate-700 px-2.5 py-1 text-xs font-semibold text-slate-200">{{ $p->status }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">{{ ucfirst($p->prioritas) }}</td>
                        <td class="px-4 py-3 text-sm">{{ $p->created_at->format('Y-m-d') }}</td>
                        @if(optional(auth()->user())->isAdmin())
                            <td class="px-4 py-3 text-sm">{{ optional($p->petugas)->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('pengaduan.show', $p) }}" class="text-cyan-300 hover:text-cyan-200">Detail</a>
                                    <form action="{{ route('pengaduan.updateStatus', $p) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="diproses">
                                        <select name="petugas_id" class="rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2 text-sm text-white">
                                            <option value="">Pilih Petugas</option>
                                            @foreach($petugasList as $pet)
                                                <option value="{{ $pet->id }}" {{ $p->petugas_id == $pet->id ? 'selected' : '' }}>{{ $pet->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="rounded-full bg-emerald-400 px-3 py-2 text-sm font-medium text-slate-950 hover:bg-emerald-300">Dispatch</button>
                                    </form>
                                </div>
                            </td>
                        @else
                            <td class="px-4 py-3 text-sm">
                                <a href="{{ route('pengaduan.show', $p) }}" class="text-cyan-300 hover:text-cyan-200">Detail</a>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-400">Belum ada pengaduan.</td>
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
