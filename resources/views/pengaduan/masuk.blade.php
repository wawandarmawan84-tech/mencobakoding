@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-semibold">Pengaduan Masuk</h1>
            <p class="text-sm text-slate-600">Daftar pengaduan untuk petugas dengan filter prioritas.</p>
        </div>
        <a href="{{ route('pengaduan.index') }}" class="text-sm text-blue-600 hover:underline">Daftar Pengaduan Warga</a>
    </div>

    <form method="GET" action="{{ route('pengaduan.masuk') }}" class="mb-4 flex flex-wrap gap-3 items-end">
        <div>
            <label for="prioritas" class="block text-sm text-slate-600">Filter Prioritas</label>
            <select id="prioritas" name="prioritas" class="mt-1 block w-full rounded border-gray-200">
                <option value="">Semua</option>
                <option value="darurat" {{ request('prioritas') === 'darurat' ? 'selected' : '' }}>Darurat</option>
                <option value="tinggi" {{ request('prioritas') === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                <option value="normal" {{ request('prioritas') === 'normal' ? 'selected' : '' }}>Normal</option>
                <option value="rendah" {{ request('prioritas') === 'rendah' ? 'selected' : '' }}>Rendah</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded">Terapkan</button>
            <a href="{{ route('pengaduan.masuk') }}" class="inline-flex items-center px-3 py-2 border rounded">Reset</a>
        </div>
    </form>

    <div class="bg-white shadow rounded">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50 text-slate-600">
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
            <tbody class="divide-y divide-slate-100">
                @forelse($pengaduans as $pengaduan)
                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $pengaduan->nomor_aduan }}</td>
                        <td class="px-4 py-3 text-sm">{{ $pengaduan->judul }}</td>
                        <td class="px-4 py-3 text-sm">{{ ucfirst($pengaduan->prioritas) }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $pengaduan->status === 'menunggu' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($pengaduan->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ optional($pengaduan->user)->name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $pengaduan->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('pengaduan.show', $pengaduan) }}" class="text-blue-600 hover:underline">Lihat</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-500">Tidak ada pengaduan masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $pengaduans->links() }}
        </div>
    </div>
</div>
@endsection
