@extends('layouts.app')

@section('content')
    <div class="rounded-[28px] border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-black/30 backdrop-blur-xl">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-medium text-cyan-300">Manajemen kategori</p>
                <h1 class="text-2xl font-semibold text-white">Manajemen Kategori</h1>
                <p class="mt-2 text-sm text-slate-400">Kelola kategori pengaduan untuk admin.</p>
            </div>
            <a href="{{ route('admin.kategori.create') }}" class="inline-flex items-center rounded-full bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">
                Tambah Kategori
            </a>
        </div>

        @if(session('success'))
            <div class="mt-4 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 p-3 text-sm text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-6 overflow-hidden rounded-[24px] border border-white/10">
            <table class="min-w-full divide-y divide-white/10">
                <thead class="bg-slate-800/80 text-slate-300">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Nama</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Deskripsi</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Icon</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10 bg-slate-900/60 text-slate-200">
                    @forelse($kategoris as $kategori)
                        <tr>
                            <td class="px-4 py-3 text-sm">{{ $kategori->nama_kategori }}</td>
                            <td class="px-4 py-3 text-sm text-slate-400">{{ $kategori->deskripsi }}</td>
                            <td class="px-4 py-3 text-sm text-slate-400">{{ $kategori->icon ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $kategori->is_active ? 'bg-emerald-400/15 text-emerald-300' : 'bg-slate-700 text-slate-300' }}">
                                    {{ $kategori->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.kategori.edit', $kategori) }}" class="text-cyan-300 hover:text-cyan-200">Edit</a>
                                    <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-400 hover:text-rose-300">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-400">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
