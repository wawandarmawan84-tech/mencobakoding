@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-cyan-300">Manajemen user</p>
                <h1 class="text-2xl font-semibold text-white">Manajemen User</h1>
                <p class="text-slate-400">Kelola akun pengguna sistem oleh admin.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-2">
                    <label for="role" class="text-sm font-medium text-slate-300">Filter role</label>
                    <select id="role" name="role" class="rounded-2xl border border-white/10 bg-slate-800/70 px-4 py-2 text-sm text-white">
                        <option value=""{{ empty($role) ? ' selected' : '' }}>Semua Role</option>
                        <option value="warga"{{ $role === 'warga' ? ' selected' : '' }}>Warga</option>
                        <option value="petugas"{{ $role === 'petugas' ? ' selected' : '' }}>Petugas</option>
                        <option value="admin"{{ $role === 'admin' ? ' selected' : '' }}>Admin</option>
                    </select>

                    <label for="status" class="text-sm font-medium text-slate-300">Status</label>
                    <select id="status" name="status" class="rounded-2xl border border-white/10 bg-slate-800/70 px-4 py-2 text-sm text-white">
                        <option value=""{{ empty($status) ? ' selected' : '' }}>Aktif</option>
                        <option value="trashed"{{ $status === 'trashed' ? ' selected' : '' }}>Terhapus</option>
                        <option value="all"{{ $status === 'all' ? ' selected' : '' }}>Semua</option>
                    </select>

                    <button type="submit" class="rounded-full bg-cyan-400 px-4 py-2 text-sm font-medium text-slate-950 hover:bg-cyan-300">Terapkan</button>
                    <a href="{{ route('admin.users.index') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-medium text-slate-300 hover:text-white">Reset</a>
                </form>
                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center rounded-full bg-emerald-400 px-4 py-2 text-sm font-medium text-slate-950 hover:bg-emerald-300">Tambah User</a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 p-4 text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-[24px] border border-white/10 bg-slate-900/70 shadow-sm backdrop-blur-xl">
            <table class="min-w-full divide-y divide-white/10 text-sm">
                <thead class="bg-slate-800/80 text-slate-300">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">Nama</th>
                        <th class="px-4 py-3 text-left font-medium">Email</th>
                        <th class="px-4 py-3 text-left font-medium">Role</th>
                        <th class="px-4 py-3 text-left font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10 text-slate-200">
                    @forelse($users as $user)
                        <tr>
                            <td class="whitespace-nowrap px-4 py-3">{{ $user->name }}</td>
                            <td class="whitespace-nowrap px-4 py-3">{{ $user->email }}</td>
                            <td class="whitespace-nowrap px-4 py-3 capitalize">
                                {{ $user->role }}
                                @if($user->trashed())
                                    <span class="ml-2 inline-flex rounded-full bg-rose-400/15 px-2 py-1 text-xs font-semibold text-rose-300">Dihapus</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <div class="flex flex-wrap gap-2">
                                    @if($user->trashed())
                                        <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" onsubmit="return confirm('Restore user ini?');">
                                            @csrf
                                            <button type="submit" class="rounded-full bg-emerald-400 px-3 py-2 text-xs font-medium text-slate-950 hover:bg-emerald-300">Restore</button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.users.edit', $user) }}" class="rounded-full border border-white/10 px-3 py-2 text-xs font-medium text-slate-300 hover:bg-slate-800/70">Edit</a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-full bg-rose-500 px-3 py-2 text-xs font-medium text-white hover:bg-rose-400">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-slate-400">Belum ada user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
