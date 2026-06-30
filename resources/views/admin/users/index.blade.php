@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Manajemen User</h1>
                <p class="text-slate-600">Kelola akun pengguna sistem oleh admin.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-2">
                    <label for="role" class="text-sm font-medium text-slate-700">Filter role</label>
                    <select id="role" name="role" class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                        <option value=""{{ empty($role) ? ' selected' : '' }}>Semua Role</option>
                        <option value="warga"{{ $role === 'warga' ? ' selected' : '' }}>Warga</option>
                        <option value="petugas"{{ $role === 'petugas' ? ' selected' : '' }}>Petugas</option>
                        <option value="admin"{{ $role === 'admin' ? ' selected' : '' }}>Admin</option>
                    </select>

                    <label for="status" class="text-sm font-medium text-slate-700">Status</label>
                    <select id="status" name="status" class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                        <option value=""{{ empty($status) ? ' selected' : '' }}>Aktif</option>
                        <option value="trashed"{{ $status === 'trashed' ? ' selected' : '' }}>Terhapus</option>
                        <option value="all"{{ $status === 'all' ? ' selected' : '' }}>Semua</option>
                    </select>

                    <button type="submit" class="rounded-xl bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-900">Terapkan</button>
                    <a href="{{ route('admin.users.index') }}" class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Reset</a>
                </form>
                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center rounded-xl bg-emerald-500 px-4 py-2 text-sm font-medium text-white shadow hover:bg-emerald-600">Tambah User</a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">Nama</th>
                        <th class="px-4 py-3 text-left font-medium">Email</th>
                        <th class="px-4 py-3 text-left font-medium">Role</th>
                        <th class="px-4 py-3 text-left font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($users as $user)
                        <tr>
                            <td class="whitespace-nowrap px-4 py-3">{{ $user->name }}</td>
                            <td class="whitespace-nowrap px-4 py-3">{{ $user->email }}</td>
                            <td class="whitespace-nowrap px-4 py-3 capitalize">
                                {{ $user->role }}
                                @if($user->trashed())
                                    <span class="ml-2 inline-flex rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold text-rose-700">Dihapus</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <div class="flex flex-wrap gap-2">
                                    @if($user->trashed())
                                        <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" onsubmit="return confirm('Restore user ini?');">
                                            @csrf
                                            <button type="submit" class="rounded-xl bg-emerald-500 px-3 py-2 text-xs font-medium text-white hover:bg-emerald-600">Restore</button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.users.edit', $user) }}" class="rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-100">Edit</a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-xl bg-rose-500 px-3 py-2 text-xs font-medium text-white hover:bg-rose-600">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-slate-500">Belum ada user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
