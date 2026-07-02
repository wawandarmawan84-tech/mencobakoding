<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil SIPENKA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="relative min-h-screen overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(34,211,238,0.25),_transparent_35%),radial-gradient(circle_at_bottom_right,_rgba(248,113,113,0.20),_transparent_30%)]"></div>

        <div class="relative mx-auto flex min-h-screen max-w-5xl items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="w-full rounded-[32px] border border-white/10 bg-slate-900/80 p-8 shadow-2xl shadow-black/40 backdrop-blur-xl sm:p-10">
                <div class="mb-8 text-center">
                    <p class="text-sm font-medium text-cyan-300">Profil akun</p>
                    <h2 class="mt-2 text-3xl font-semibold text-white">Profil Saya</h2>
                    <p class="mt-2 text-sm text-slate-400">Perbarui data profil Anda agar akun tetap terawat.</p>
                </div>

                @if (session('status'))
                    <div class="mb-6 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 p-4 text-sm text-emerald-300">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col items-center space-y-4 rounded-2xl border border-white/10 bg-slate-800/60 p-4 sm:flex-row sm:items-center sm:space-x-4 sm:space-y-0">
                        <div class="h-24 w-24 overflow-hidden rounded-full border-4 border-cyan-400/20 bg-slate-700 shadow-sm">
                            <img id="avatarPreview" src="@if ($user->avatar) {{ asset('storage/' . $user->avatar) }} @else {{ asset('images/default-avatar.svg') }} @endif" alt="Avatar" class="h-full w-full object-cover">
                        </div>
                        <div class="w-full sm:flex-1">
                            <label for="avatar" class="block text-sm font-medium text-slate-200">Foto Profil</label>
                            <input id="avatar" name="avatar" type="file" accept="image/*" class="mt-1 block w-full text-sm text-slate-400 file:mr-4 file:rounded-full file:border-0 file:bg-cyan-400/15 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-cyan-300 hover:file:bg-cyan-400/25">
                            <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
                            @error('avatar')<p class="mt-1 text-sm text-rose-400">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-slate-200">Nama Lengkap</label>
                        <input id="name" name="name" type="text" required value="{{ old('name', $user->name) }}" class="block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-4 py-3 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20">
                        @error('name')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-slate-200">Email</label>
                        <input id="email" name="email" type="email" required value="{{ old('email', $user->email) }}" class="block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-4 py-3 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20">
                        @error('email')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="no_hp" class="mb-2 block text-sm font-medium text-slate-200">Nomor HP</label>
                        <input id="no_hp" name="no_hp" type="text" value="{{ old('no_hp', $user->no_hp) }}" class="block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-4 py-3 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20" maxlength="15">
                        @error('no_hp')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <button type="submit" class="flex w-full justify-center rounded-2xl bg-cyan-400 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('avatar');
            const preview = document.getElementById('avatarPreview');

            if (input && preview) {
                input.addEventListener('change', function (event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            preview.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
</body>
</html>
