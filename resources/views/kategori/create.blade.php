@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl rounded-[28px] border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-black/30 backdrop-blur-xl">
        <div class="mb-6">
            <p class="text-sm font-medium text-cyan-300">Tambah kategori</p>
            <h1 class="text-2xl font-semibold text-white">Tambah Kategori</h1>
            <p class="mt-2 text-sm text-slate-400">Buat kategori baru untuk pengaduan masyarakat.</p>
        </div>

        <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-200">Nama Kategori</label>
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" required class="w-full rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2.5 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20" />
                @error('nama_kategori')<p class="mt-1 text-sm text-rose-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-200">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2.5 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<p class="mt-1 text-sm text-rose-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-200">Icon</label>
                <input type="text" name="icon" value="{{ old('icon') }}" class="w-full rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2.5 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20" />
                @error('icon')<p class="mt-1 text-sm text-rose-400">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-2 rounded-2xl border border-white/10 bg-slate-800/50 px-3 py-3">
                <input type="hidden" name="is_active" value="0" />
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 rounded border-white/10 bg-slate-800 text-cyan-400" />
                <label class="text-sm text-slate-300">Aktif</label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="rounded-full bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">Simpan</button>
                <a href="{{ route('admin.kategori.index') }}" class="text-sm text-slate-300 hover:text-white">Batal</a>
            </div>
        </form>
    </div>
@endsection
