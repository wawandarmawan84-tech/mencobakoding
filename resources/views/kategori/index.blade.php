@extends('layouts.app')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">Manajemen Kategori</h1>
                <p class="mt-2 text-sm text-slate-500">Kelola kategori pengaduan untuk admin.</p>
            </div>
            <a href="{{ route('kategori.create') }}" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                Tambah Kategori
            </a>
        </div>

        @if(session('success'))
            <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-6 overflow-hidden rounded-xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Nama</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Deskripsi</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Icon</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($kategoris as $kategori)
                        <tr>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $kategori->nama_kategori }}</td>
                            <td class="px-4 py-3 text-sm text-slate-500">{{ $kategori->deskripsi }}</td>
                            <td class="px-4 py-3 text-sm text-slate-500">{{ $kategori->icon ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="rounded-full px-2 py-1 {{ $kategori->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $kategori->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('kategori.edit', $kategori) }}" class="text-sky-600 hover:text-sky-700">Edit</a>
                                    <form action="{{ route('kategori.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-700">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
