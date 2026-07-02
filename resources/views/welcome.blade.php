<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SIPENKA | Sistem Informasi Pengaduan</title>

        @fonts

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                :root { color-scheme: dark; }
                body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
            </style>
        @endif
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(34,211,238,0.25),_transparent_35%),radial-gradient(circle_at_bottom_right,_rgba(248,113,113,0.22),_transparent_30%)]"></div>

            <header class="relative mx-auto flex max-w-7xl items-center justify-between px-6 py-6 lg:px-8">
                <a href="{{ url('/') }}" class="text-xl font-semibold uppercase tracking-[0.35em] text-cyan-300">
                    SIPENKA
                </a>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-full border border-cyan-400/40 bg-cyan-400/10 px-4 py-2 text-sm font-medium text-cyan-200 transition hover:bg-cyan-400/20">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-full border border-white/15 px-4 py-2 text-sm font-medium text-slate-200 transition hover:bg-white/10">
                                Masuk
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-full bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <main class="relative mx-auto flex max-w-7xl flex-col gap-8 px-6 py-8 lg:px-8 lg:py-12">
                <section class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
                    <div class="rounded-[28px] border border-white/10 bg-white/10 p-8 shadow-2xl shadow-cyan-950/30 backdrop-blur-xl">
                        <span class="inline-flex rounded-full border border-cyan-400/30 bg-cyan-400/10 px-3 py-1 text-sm font-medium text-cyan-200">
                            Sistem Informasi Pengaduan Masyarakat
                        </span>
                        <h1 class="mt-5 text-4xl font-semibold leading-tight text-white sm:text-5xl">
                            Laporkan masalah Anda dengan cepat, aman, dan transparan.
                        </h1>
                        <p class="mt-4 max-w-2xl text-lg text-slate-300">
                            SIPENKA membantu warga menyampaikan pengaduan, memantau perkembangan, dan memastikan setiap laporan mendapat tindak lanjut yang jelas.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="rounded-full bg-cyan-400 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">
                                    Buka Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-full bg-cyan-400 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">
                                    Masuk Sekarang
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-full border border-white/15 px-5 py-3 text-sm font-semibold text-slate-100 transition hover:bg-white/10">
                                        Buat Akun
                                    </a>
                                @endif
                            @endauth
                        </div>

                        <div class="mt-8 flex flex-wrap gap-3 text-sm text-slate-300">
                            <span class="rounded-full border border-white/10 bg-slate-900/70 px-3 py-2">⚡ Proses cepat</span>
                            <span class="rounded-full border border-white/10 bg-slate-900/70 px-3 py-2">📍 Pantau status</span>
                            <span class="rounded-full border border-white/10 bg-slate-900/70 px-3 py-2">🛡️ Aman dan terpercaya</span>
                        </div>
                    </div>

                    <div class="rounded-[28px] border border-cyan-400/20 bg-slate-900/80 p-6 shadow-2xl shadow-slate-950/40 backdrop-blur-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-cyan-200">Ringkasan hari ini</p>
                                <h2 class="mt-1 text-2xl font-semibold text-white">Kinerja layanan</h2>
                            </div>
                            <span class="rounded-full bg-emerald-500/15 px-3 py-1 text-sm font-medium text-emerald-300">
                                Online
                            </span>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-slate-300">Laporan masuk</span>
                                    <span class="text-lg font-semibold text-white">128</span>
                                </div>
                                <div class="mt-2 h-2 rounded-full bg-slate-800">
                                    <div class="h-2 w-[82%] rounded-full bg-cyan-400"></div>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-slate-300">Selesai</span>
                                    <span class="text-lg font-semibold text-white">94</span>
                                </div>
                                <div class="mt-2 h-2 rounded-full bg-slate-800">
                                    <div class="h-2 w-[73%] rounded-full bg-emerald-400"></div>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-slate-300">Menunggu tindak lanjut</span>
                                    <span class="text-lg font-semibold text-white">34</span>
                                </div>
                                <div class="mt-2 h-2 rounded-full bg-slate-800">
                                    <div class="h-2 w-[42%] rounded-full bg-amber-400"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="grid gap-6 md:grid-cols-3">
                    <div class="rounded-2xl border border-white/10 bg-slate-900/70 p-5">
                        <h3 class="text-lg font-semibold text-white">1. Buat laporan</h3>
                        <p class="mt-2 text-sm text-slate-300">Sampaikan masalah Anda dengan form yang sederhana dan jelas.</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-slate-900/70 p-5">
                        <h3 class="text-lg font-semibold text-white">2. Pantau perkembangan</h3>
                        <p class="mt-2 text-sm text-slate-300">Lihat status pengaduan Anda kapan saja tanpa kebingungan.</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-slate-900/70 p-5">
                        <h3 class="text-lg font-semibold text-white">3. Dapatkan solusi</h3>
                        <p class="mt-2 text-sm text-slate-300">Setiap laporan akan ditangani agar masalah terselesaikan dengan cepat.</p>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
