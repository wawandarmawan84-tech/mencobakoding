<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIPENKA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="relative min-h-screen overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(34,211,238,0.25),_transparent_35%),radial-gradient(circle_at_bottom_right,_rgba(248,113,113,0.20),_transparent_30%)]"></div>

        <div class="relative mx-auto flex min-h-screen max-w-7xl items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid w-full max-w-5xl overflow-hidden rounded-[32px] border border-white/10 bg-slate-900/80 shadow-2xl shadow-black/40 backdrop-blur-xl lg:grid-cols-[1.05fr_0.95fr]">
                <div class="relative hidden bg-gradient-to-br from-cyan-500/20 via-slate-900 to-slate-950 p-10 lg:flex lg:flex-col lg:justify-between">
                    <div>
                        <a href="{{ url('/') }}" class="text-lg font-semibold uppercase tracking-[0.35em] text-cyan-300">SIPENKA</a>
                        <h1 class="mt-8 text-3xl font-semibold leading-tight text-white">
                            Selamat datang kembali di sistem pengaduan Anda.
                        </h1>
                        <p class="mt-4 max-w-md text-sm leading-6 text-slate-300">
                            Masuk untuk melihat status laporan, melanjutkan tanggapan, dan memastikan setiap pengaduan terselesaikan dengan baik.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-cyan-400/20 bg-slate-800/70 p-4 text-sm text-slate-300">
                        <p class="font-medium text-cyan-200">Kenapa memilih SIPENKA?</p>
                        <ul class="mt-3 space-y-2">
                            <li>• Proses login cepat dan aman</li>
                            <li>• Pantau perkembangan laporan secara real-time</li>
                            <li>• Akses dashboard yang informatif</li>
                        </ul>
                    </div>
                </div>

                <div class="p-8 sm:p-10 lg:p-12">
                    <div class="mb-8 text-center lg:text-left">
                        <p class="text-sm font-medium text-cyan-300">Masuk ke akun</p>
                        <h2 class="mt-2 text-3xl font-semibold text-white">Selamat datang</h2>
                        <p class="mt-2 text-sm text-slate-400">Silakan login untuk mengakses sistem pengaduan.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-slate-200">Email</label>
                            <input id="email" name="email" type="email" required value="{{ old('email') }}" class="block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-4 py-3 text-sm text-white shadow-sm outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30">
                            @error('email')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-medium text-slate-200">Password</label>
                            <input id="password" name="password" type="password" required class="block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-4 py-3 text-sm text-white shadow-sm outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30">
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="remember" class="rounded border-white/10 bg-slate-800 text-cyan-400 focus:ring-cyan-400">
                                <span class="ml-2 text-sm text-slate-400">Ingat saya</span>
                            </label>
                            <a href="{{ route('register') }}" class="text-sm font-medium text-cyan-300 hover:text-cyan-200">Daftar</a>
                        </div>

                        <div>
                            <button type="submit" class="flex w-full justify-center rounded-2xl bg-cyan-400 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">
                                Masuk
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center text-sm text-slate-400">
                        Belum punya akun? <a href="{{ route('register') }}" class="font-medium text-cyan-300 hover:text-cyan-200">Buat akun sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
