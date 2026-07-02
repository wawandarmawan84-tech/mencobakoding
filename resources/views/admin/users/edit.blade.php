@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-6">
            <p class="text-sm font-medium text-cyan-300">Edit user</p>
            <h1 class="text-2xl font-semibold text-white">Edit User</h1>
            <p class="text-slate-400">Perbarui data akun pengguna.</p>
        </div>

        <div class="rounded-[28px] border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-black/30 backdrop-blur-xl">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-200">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-2xl border border-white/10 bg-slate-800/70 px-4 py-3 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20" required>
                        @error('name')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-200">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-2xl border border-white/10 bg-slate-800/70 px-4 py-3 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20" required>
                        @error('email')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-200">Role</label>
                        <select name="role" class="w-full rounded-2xl border border-white/10 bg-slate-800/70 px-4 py-3 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20" required>
                            <option value="warga" {{ old('role', $user->role) === 'warga' ? 'selected' : '' }}>Warga</option>
                            <option value="petugas" {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-200">Password Baru (opsional)</label>
                        <input type="password" name="password" class="w-full rounded-2xl border border-white/10 bg-slate-800/70 px-4 py-3 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20">
                        @error('password')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-200">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full rounded-2xl border border-white/10 bg-slate-800/70 px-4 py-3 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20">
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.users.index') }}" class="rounded-full border border-white/10 px-4 py-3 text-sm font-medium text-slate-300 hover:bg-slate-800/70">Batal</a>
                        <button type="submit" class="rounded-full bg-cyan-400 px-4 py-3 text-sm font-medium text-slate-950 hover:bg-cyan-300">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
