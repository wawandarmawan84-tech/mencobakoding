@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl">
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm font-medium text-cyan-300">Detail pengaduan</p>
            <h1 class="text-2xl font-semibold text-white">Detail Pengaduan</h1>
            <p class="mt-1 text-sm text-slate-400">Nomor: {{ $pengaduan->nomor_aduan }}</p>
        </div>
        <a href="{{ route('pengaduan.index') }}" class="text-sm text-cyan-300 hover:text-cyan-200">Kembali ke daftar</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 p-4 text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-4 lg:col-span-2">
            <div class="rounded-[24px] border border-white/10 bg-slate-900/70 p-5 shadow-lg shadow-black/20 backdrop-blur-xl">
                <h2 class="mb-3 text-lg font-medium text-white">Informasi Pengaduan</h2>
                <div class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <p class="text-sm text-slate-400">Judul</p>
                        <p class="mt-1 font-medium text-slate-100">{{ $pengaduan->judul }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400">Kategori</p>
                        <p class="mt-1 font-medium text-slate-100">{{ optional($pengaduan->kategori)->nama_kategori }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400">Prioritas</p>
                        <p class="mt-1 font-medium text-slate-100">{{ ucfirst($pengaduan->prioritas) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400">Tanggal</p>
                        <p class="mt-1 font-medium text-slate-100">{{ $pengaduan->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>

                <div class="mt-5">
                    <p class="text-sm text-slate-400">Lokasi</p>
                    <p class="mt-1 text-slate-200">{{ $pengaduan->lokasi ?? '-' }}</p>
                </div>

                <div class="mt-5">
                    <p class="text-sm text-slate-400">Deskripsi</p>
                    <p class="mt-1 whitespace-pre-line text-slate-200">{{ $pengaduan->isi_pengaduan }}</p>
                </div>
            </div>

            <div class="rounded-[24px] border border-white/10 bg-slate-900/70 p-5 shadow-lg shadow-black/20 backdrop-blur-xl">
                <h2 class="mb-3 text-lg font-medium text-white">Timeline Status</h2>
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
                            <div class="mt-1 h-3 w-3 rounded-full {{ $pengaduan->status === $stepKey ? 'bg-cyan-400' : 'bg-slate-600' }}"></div>
                            <div>
                                <p class="font-medium text-slate-100">{{ $label }}</p>
                                <p class="text-sm text-slate-400">{{ $pengaduan->status === $stepKey ? 'Status saat ini' : ($pengaduan->status === 'selesai' && $stepKey === 'diproses' ? 'Sebelumnya diproses' : '') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-[24px] border border-white/10 bg-slate-900/70 p-5 shadow-lg shadow-black/20 backdrop-blur-xl">
                <h2 class="mb-3 text-lg font-medium text-white">Status dan Catatan</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-slate-400">Status</p>
                        <div class="mt-1 inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $pengaduan->status === 'menunggu' ? 'bg-amber-400/15 text-amber-300' : ($pengaduan->status === 'diproses' ? 'bg-cyan-400/15 text-cyan-300' : ($pengaduan->status === 'selesai' ? 'bg-emerald-400/15 text-emerald-300' : 'bg-rose-400/15 text-rose-300')) }}">
                            {{ ucfirst($pengaduan->status) }}
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-slate-400">Catatan Petugas</p>
                        <p class="mt-1 text-sm {{ $pengaduan->catatan_petugas ? 'text-slate-100' : 'text-slate-500' }}">{{ $pengaduan->catatan_petugas ?? 'Belum ada catatan.' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-400">Petugas</p>
                        <p class="mt-1 text-sm text-slate-100">{{ optional($pengaduan->petugas)->name ?? 'Belum ditugaskan' }}</p>
                    </div>
                </div>

                @if(auth()->user()->isPetugas() || auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('pengaduan.updateStatus', $pengaduan) }}" class="mt-6 space-y-4" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        @if(auth()->user()->isAdmin())
                            <div>
                                <label for="petugas_id" class="block text-sm font-medium text-slate-200">Penugasan Petugas</label>
                                <select id="petugas_id" name="petugas_id" class="mt-1 block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2.5 text-sm text-white">
                                    <option value="">Tidak ditugaskan</option>
                                    @foreach(App\Models\User::where('role', 'petugas')->orderBy('name')->get() as $petugas)
                                        <option value="{{ $petugas->id }}" {{ old('petugas_id', $pengaduan->petugas_id) == $petugas->id ? 'selected' : '' }}>{{ $petugas->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div>
                            <label for="status" class="block text-sm font-medium text-slate-200">Update Status</label>
                            <select id="status" name="status" class="mt-1 block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2.5 text-sm text-white">
                                <option value="menunggu" {{ $pengaduan->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ $pengaduan->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $pengaduan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $pengaduan->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="catatan_petugas" class="block text-sm font-medium text-slate-200">Catatan Penanganan</label>
                            <textarea id="catatan_petugas" name="catatan_petugas" rows="4" class="mt-1 block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2.5 text-sm text-white">{{ old('catatan_petugas', $pengaduan->catatan_petugas) }}</textarea>
                            @error('catatan_petugas')
                                <p class="mt-2 text-sm text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="evidence_photo" class="block text-sm font-medium text-slate-200">Lampiran Foto Bukti (hanya saat close)</label>
                            <input id="evidence_photo" type="file" name="evidence_photo" accept="image/*" class="mt-1 block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2.5 text-sm text-white" />
                            @error('evidence_photo')
                                <p class="mt-2 text-sm text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="inline-flex items-center rounded-full bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">Simpan Perubahan</button>
                    </form>
                @endif
            </div>

            <div class="rounded-[24px] border border-white/10 bg-slate-900/70 p-5 shadow-lg shadow-black/20 backdrop-blur-xl">
                <h2 class="mb-3 text-lg font-medium text-white">Lampiran</h2>
                @if($pengaduan->lampiran->isEmpty())
                    <p class="text-sm text-slate-400">Tidak ada lampiran.</p>
                @else
                    <ul class="space-y-3">
                        @foreach($pengaduan->lampiran as $lampiran)
                            <li class="rounded-2xl border border-white/10 bg-slate-800/50 p-3">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="font-medium text-slate-100">{{ $lampiran->nama_file }}</p>
                                        <p class="text-sm text-slate-400">{{ strtoupper($lampiran->tipe_file) }} · {{ number_format($lampiran->ukuran_file / 1024, 2) }} KB</p>
                                    </div>
                                    <a href="{{ asset('storage/' . $lampiran->path_file) }}" target="_blank" class="text-sm text-cyan-300 hover:text-cyan-200">Lihat</a>
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
