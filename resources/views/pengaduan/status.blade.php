@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Ubah Status Pengaduan — {{ $pengaduan->nomor_aduan }}</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow rounded p-4 mb-4">
        <h2 class="font-medium">Judul</h2>
        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $pengaduan->judul }}</p>

        <h2 class="font-medium mt-4">Pelapor</h2>
        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $pengaduan->user->name }} ({{ $pengaduan->user->email }})</p>

        <h2 class="font-medium mt-4">Isi</h2>
        <p class="text-sm whitespace-pre-line text-gray-700 dark:text-gray-300">{{ $pengaduan->isi_pengaduan }}</p>
    </div>

    <form action="{{ route('pengaduan.updateStatus', $pengaduan) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium">Petugas</label>
                <select name="petugas_id" class="mt-1 block w-full rounded border-gray-300">
                    <option value="">-- Pilih petugas --</option>
                    @foreach($petugasList as $p)
                        <option value="{{ $p->id }}" @if($pengaduan->petugas_id == $p->id) selected @endif>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Status</label>
                <select name="status" class="mt-1 block w-full rounded border-gray-300" required>
                    <option value="menunggu" @if($pengaduan->status=='menunggu') selected @endif>Menunggu</option>
                    <option value="diproses" @if($pengaduan->status=='diproses') selected @endif>Diproses</option>
                    <option value="selesai" @if($pengaduan->status=='selesai') selected @endif>Selesai</option>
                    <option value="ditolak" @if($pengaduan->status=='ditolak') selected @endif>Ditolak</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Catatan Petugas (opsional)</label>
                <textarea name="catatan_petugas" class="mt-1 block w-full rounded border-gray-300" rows="4">{{ old('catatan_petugas', $pengaduan->catatan_petugas) }}</textarea>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('pengaduan.show', $pengaduan) }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>
@endsection
