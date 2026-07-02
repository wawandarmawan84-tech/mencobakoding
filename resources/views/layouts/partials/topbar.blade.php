<header class="border-b border-white/10 bg-slate-900/70 px-4 py-4 shadow-sm backdrop-blur-xl sm:px-6 lg:px-8">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <button type="button" data-sidebar-toggle class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-slate-800/80 text-slate-100 shadow-sm lg:hidden" aria-label="Buka menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div>
                <p class="text-sm font-medium text-cyan-300">Selamat datang</p>
                <h2 class="text-xl font-semibold text-white">Sistem Pengaduan Masyarakat</h2>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <details class="group relative">
                <summary class="relative cursor-pointer rounded-full border border-white/10 bg-slate-800/80 p-2.5 text-slate-200 transition hover:bg-slate-700" aria-label="Notifikasi">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.4-1.4a2 2 0 01-.6-1.4V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0a3 3 0 11-6 0" />
                    </svg>
                    @php
                        $unreadNotifications = collect();
                        try {
                            if (\Illuminate\Support\Facades\Schema::hasTable('notifications') && auth()->check()) {
                                $unreadNotifications = auth()->user()->unreadNotifications ?? collect();
                            }
                        } catch (\Exception $e) {
                            $unreadNotifications = collect();
                        }
                    @endphp
                    @if($unreadNotifications->count() > 0)
                        <span class="absolute right-1 top-1 inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                    @endif
                </summary>

                <div class="absolute right-0 z-10 mt-2 w-80 rounded-xl border border-white/10 bg-slate-900/95 p-2 shadow-lg">
                    <div class="mb-2 px-2 text-sm font-semibold text-white">Notifikasi</div>
                    @php
                        $notifications = collect();
                        try {
                            if (\Illuminate\Support\Facades\Schema::hasTable('notifications') && auth()->check()) {
                                $notifications = auth()->user()->notifications()->latest()->take(5)->get() ?? collect();
                            }
                        } catch (\Exception $e) {
                            $notifications = collect();
                        }
                    @endphp
                    @if($notifications->isEmpty())
                        <div class="rounded-lg px-3 py-2 text-sm text-slate-400">Belum ada notifikasi.</div>
                    @else
                        @foreach($notifications as $notification)
                            <a href="{{ $notification->data['url'] ?? '#' }}" class="block rounded-lg px-3 py-2 text-sm {{ $notification->read_at ? 'text-slate-400' : 'text-slate-100 bg-slate-800/70' }} hover:bg-slate-800">
                                <div class="font-medium">{{ $notification->data['message'] ?? 'Notifikasi baru' }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $notification->created_at->diffForHumans() }}</div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </details>

            <div class="relative">
                <details class="group relative">
                    <summary class="flex cursor-pointer list-none items-center gap-2 rounded-full border border-white/10 bg-slate-800/80 px-3 py-2">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-cyan-400 font-semibold text-slate-950">
                            {{ strtoupper(substr(optional(auth()->user())->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-semibold text-white">{{ optional(auth()->user())->name ?? 'User' }}</p>
                            <p class="text-xs text-slate-400">{{ optional(auth()->user())->email ?? 'user@example.com' }}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>

                    <div class="absolute right-0 z-10 mt-2 w-48 rounded-xl border border-white/10 bg-slate-900/95 p-2 shadow-lg">
                        <a href="{{ url('/profile') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-200 hover:bg-slate-800">
                            Profil
                        </a>
                        @if (Route::has('logout'))
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center rounded-lg px-3 py-2 text-left text-sm text-slate-200 hover:bg-slate-800">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ url('/') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-200 hover:bg-slate-800">
                                Logout
                            </a>
                        @endif
                    </div>
                </details>
            </div>
        </div>
    </div>
</header>
