@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Detail Pengaduan</h1>
            <p class="text-sm text-slate-600">Nomor: {{ $pengaduan->nomor_aduan }}</p>
        </div>
        <a href="{{ route('pengaduan.index') }}" class="text-sm text-blue-600 hover:underline">Kembali ke daftar</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded border border-green-200 bg-green-50 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white shadow rounded p-5">
                <h2 class="text-lg font-medium mb-3">Informasi Pengaduan</h2>
                <div class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <p class="text-sm text-slate-600">Judul</p>
                        <p class="mt-1 font-medium">{{ $pengaduan->judul }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Kategori</p>
                        <p class="mt-1 font-medium">{{ optional($pengaduan->kategori)->nama_kategori }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Prioritas</p>
                        <p class="mt-1 font-medium">{{ ucfirst($pengaduan->prioritas) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600">Tanggal</p>
                        <p class="mt-1 font-medium">{{ $pengaduan->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>

                <div class="mt-5">
                    <p class="text-sm text-slate-600">Lokasi</p>
                    <p class="mt-1">{{ $pengaduan->lokasi ?? '-' }}</p>
                </div>

                <div class="mt-5">
                    <p class="text-sm text-slate-600">Deskripsi</p>
                    <p class="mt-1 whitespace-pre-line">{{ $pengaduan->isi_pengaduan }}</p>
                </div>
            </div>

            <div class="bg-white shadow rounded p-5">
                <h2 class="text-lg font-medium mb-3">Timeline Status</h2>
                <div class="space-y-4">
                    @php
                        $steps = [
                            'menunggu' => 'Menunggu',
                            'diproses' => 'Diproses',
                            'selesai' => 'Selesai',
                            'ditolak' => 'Ditolak',
                        ];
                    @endphp

                    @foreach($steps as $stepKey => $label)
                        <div class="flex items-start gap-3">
                            <div class="mt-1 h-3 w-3 rounded-full {{ $pengaduan->status === $stepKey ? 'bg-blue-600' : 'bg-slate-300' }}"></div>
                            <div>
                                <p class="font-medium">{{ $label }}</p>
                                <p class="text-sm text-slate-500">{{ $pengaduan->status === $stepKey ? 'Status saat ini' : ($pengaduan->status === 'selesai' && $stepKey === 'diproses' ? 'Sebelumnya diproses' : '') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white shadow rounded p-5">
                <h2 class="text-lg font-medium mb-3">Status dan Catatan</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-slate-600">Status</p>
                        <div class="mt-1 inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $pengaduan->status === 'menunggu' ? 'bg-yellow-100 text-yellow-800' : ($pengaduan->status === 'diproses' ? 'bg-blue-100 text-blue-800' : ($pengaduan->status === 'selesai' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                            {{ ucfirst($pengaduan->status) }}
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-slate-600">Catatan Petugas</p>
                        <p class="mt-1 text-sm {{ $pengaduan->catatan_petugas ? 'text-slate-800' : 'text-slate-500' }}">{{ $pengaduan->catatan_petugas ?? 'Belum ada catatan.' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-600">Petugas</p>
                        <p class="mt-1 text-sm text-slate-800">{{ optional($pengaduan->petugas)->name ?? 'Belum ditugaskan' }}</p>
                    </div>
                </div>

                @if(auth()->user()->isPetugas())
                    <form method="POST" action="{{ route('pengaduan.updateStatus', $pengaduan) }}" class="mt-6 space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="status" class="block text-sm font-medium text-slate-700">Update Status</label>
                            <select id="status" name="status" class="mt-1 block w-full rounded border-gray-200">
                                <option value="menunggu" {{ $pengaduan->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ $pengaduan->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $pengaduan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $pengaduan->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="catatan_petugas" class="block text-sm font-medium text-slate-700">Catatan Penanganan</label>
                            <textarea id="catatan_petugas" name="catatan_petugas" rows="4" class="mt-1 block w-full rounded border-gray-200">{{ old('catatan_petugas', $pengaduan->catatan_petugas) }}</textarea>
                            @error('catatan_petugas')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded">Simpan Perubahan</button>
                    </form>
                @endif
            </div>

            <div class="bg-white shadow rounded p-5">
                <h2 class="text-lg font-medium mb-3">Lampiran</h2>
                @if($pengaduan->lampiran->isEmpty())
                    <p class="text-sm text-slate-500">Tidak ada lampiran.</p>
                @else
                    <ul class="space-y-3">
                        @foreach($pengaduan->lampiran as $lampiran)
                            <li class="border rounded p-3">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="font-medium">{{ $lampiran->nama_file }}</p>
                                        <p class="text-sm text-slate-500">{{ strtoupper($lampiran->tipe_file) }} · {{ number_format($lampiran->ukuran_file / 1024, 2) }} KB</p>
                                    </div>
                                    <a href="{{ asset('storage/' . $lampiran->path_file) }}" target="_blank" class="text-blue-600 hover:underline text-sm">Lihat</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
