@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Manajemen User</h1>
                <p class="text-slate-600">Kelola akun pengguna sistem oleh admin.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center rounded-xl bg-emerald-500 px-4 py-2 text-sm font-medium text-white shadow hover:bg-emerald-600">Tambah User</a>
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
                            <td class="whitespace-nowrap px-4 py-3 capitalize">{{ $user->role }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-100">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-xl bg-rose-500 px-3 py-2 text-xs font-medium text-white hover:bg-rose-600">Hapus</button>
                                    </form>
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
