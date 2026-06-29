@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Daftar Pengaduan Saya</h1>
        <a href="/" class="text-sm text-slate-600">Kembali</a>
    </div>

    <form method="GET" action="{{ route('pengaduan.index') }}" class="mb-4 flex gap-3 items-end">
        <div>
            <label class="block text-sm text-slate-600">Status</label>
            <select name="status" class="mt-1 block w-full rounded border-gray-200">
                <option value="">Semua</option>
                <option value="menunggu" {{ request('status')=='menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="diproses" {{ request('status')=='diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ request('status')=='selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="ditolak" {{ request('status')=='ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <div>
            <label class="block text-sm text-slate-600">Kategori</label>
            <select name="kategori_id" class="mt-1 block w-full rounded border-gray-200">
                <option value="">Semua</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}" {{ (string)request('kategori_id') === (string)$kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded">Filter</button>
            <a href="{{ route('pengaduan.index') }}" class="inline-flex items-center px-3 py-2 ml-2 border rounded">Reset</a>
        </div>
    </form>

    <div class="bg-white shadow rounded">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium">Nomor</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Judul</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Kategori</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Prioritas</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pengaduans as $p)
                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $p->nomor_aduan }}</td>
                        <td class="px-4 py-3 text-sm">{{ $p->judul }}</td>
                        <td class="px-4 py-3 text-sm">{{ optional($p->kategori)->nama_kategori }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($p->status === 'menunggu')
                                <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Menunggu</span>
                            @elseif($p->status === 'diproses')
                                <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">Diproses</span>
                            @elseif($p->status === 'selesai')
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Selesai</span>
                            @elseif($p->status === 'ditolak')
                                <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Ditolak</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-slate-100 text-slate-800">{{ $p->status }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">{{ ucfirst($p->prioritas) }}</td>
                        <td class="px-4 py-3 text-sm">{{ $p->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada pengaduan.</td>
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
