@extends('layouts.app')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-semibold text-slate-800">Edit Kategori</h1>
        <p class="mt-2 text-sm text-slate-500">Perbarui informasi kategori pengaduan.</p>

        <form action="{{ route('kategori.update', $kategori) }}" method="POST" class="mt-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Nama Kategori</label>
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('nama_kategori')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                @error('deskripsi')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Icon</label>
                <input type="text" name="icon" value="{{ old('icon', $kategori->icon) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('icon')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="hidden" name="is_active" value="0" />
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $kategori->is_active) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300" />
                <label class="text-sm text-slate-700">Aktif</label>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Perbarui</button>
                <a href="{{ route('kategori.index') }}" class="text-sm text-slate-600 hover:text-slate-800">Batal</a>
            </div>
        </form>
    </div>
@endsection
