<header class="border-b border-slate-200 bg-white px-4 py-4 shadow-sm sm:px-6 lg:px-8">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500">Selamat datang</p>
            <h2 class="text-xl font-semibold text-slate-800">Sistem Pengaduan Masyarakat</h2>
        </div>

        <div class="flex items-center gap-3">
            <button class="rounded-full border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-600">
                🔔 Notifikasi
            </button>
            <div class="flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-3 py-2">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-500 font-semibold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="text-left">
                    <p class="text-sm font-semibold text-slate-800">{{ optional(auth()->user())->name ?? 'User' }}</p>
                    <p class="text-xs text-slate-500">{{ optional(auth()->user())->email ?? 'user@example.com' }}</p>
                </div>
            </div>
        </div>
    </div>
</header>
