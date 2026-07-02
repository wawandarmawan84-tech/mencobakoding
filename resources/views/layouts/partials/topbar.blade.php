<header class="border-b border-white/10 bg-slate-900/70 px-4 py-4 shadow-sm backdrop-blur-xl sm:px-6 lg:px-8">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <form action="{{ route('pengaduan.index') }}" method="GET" class="hidden sm:flex items-center relative">
                <label for="q" class="sr-only">Cari pengaduan</label>
                <div class="relative">
                    <input id="q" name="q" value="{{ request('q') }}" placeholder="Cari tiket atau judul..." type="search" class="w-64 rounded-2xl border border-white/10 bg-slate-800/80 px-3 py-2 text-sm text-slate-200 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400" />
                    <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 rounded-full p-1 text-slate-400 hover:text-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                    </button>
                </div>
                <div id="searchSuggestions" class="absolute mt-1 w-80 rounded-xl border border-white/10 bg-slate-900/95 p-1 shadow-lg hidden" role="listbox" aria-label="Hasil pencarian"></div>
            </form>
            
            <!-- Mobile search toggle -->
            <button id="mobileSearchToggle" class="sm:hidden inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-slate-800/80 text-slate-100 shadow-sm" aria-label="Cari">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
            </button>

            <div id="mobileSearchOverlay" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
                <div class="w-full max-w-md rounded-xl bg-slate-900 p-4">
                    <div class="flex items-center gap-2">
                        <input id="mobile-q" placeholder="Cari tiket atau judul..." type="search" class="w-full rounded-2xl border border-white/10 bg-slate-800/80 px-3 py-2 text-sm text-slate-200" />
                        <button id="mobileSearchClose" class="rounded-full px-3 py-2 text-slate-200">Batal</button>
                    </div>
                    <div id="mobileSearchSuggestions" class="mt-2 rounded-md"></div>
                </div>
            </div>
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

<script>
    (function () {
        const input = document.getElementById('q');
        const suggestions = document.getElementById('searchSuggestions');
        const mobileToggle = document.getElementById('mobileSearchToggle');
        const mobileOverlay = document.getElementById('mobileSearchOverlay');
        const mobileClose = document.getElementById('mobileSearchClose');
        const mobileInput = document.getElementById('mobile-q');
        const mobileSuggestions = document.getElementById('mobileSearchSuggestions');
        if (!input || !suggestions) return;

        let timer = null;
        let activeIndex = -1;

        function statusBadge(status) {
            const map = {
                'menunggu': 'bg-amber-400/10 text-amber-300 border-amber-400/20',
                'diproses': 'bg-cyan-400/10 text-cyan-300 border-cyan-400/20',
                'selesai': 'bg-emerald-400/10 text-emerald-300 border-emerald-400/20',
                'ditolak': 'bg-rose-400/10 text-rose-300 border-rose-400/20',
            };
            return map[status] || 'bg-slate-700 text-slate-200 border-white/10';
        }

        function renderItems(items, container) {
            container = container || suggestions;
            if (!items || items.length === 0) {
                container.classList.add('hidden');
                container.innerHTML = '';
                activeIndex = -1;
                return;
            }

            container.innerHTML = items.map((i, idx) => `
                <a href="${i.url}" data-idx="${idx}" role="option" class="result-item block rounded-lg px-3 py-2 text-sm text-slate-200 hover:bg-slate-800">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <div class="font-medium">${i.nomor} — ${escapeHtml(i.judul)}</div>
                            <div class="text-xs text-slate-400 mt-1">${i.created_at}</div>
                        </div>
                        <div class="ml-2 self-start">
                            <span class="inline-flex items-center gap-2 rounded-full px-2 py-1 text-xs font-semibold ${statusBadge(i.status)} border">${i.status}</span>
                        </div>
                    </div>
                </a>
            `).join('');

            // reset active
            activeIndex = -1;
            container.classList.remove('hidden');
        }

        function escapeHtml(unsafe) {
            return (unsafe || '')
                .toString()
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/\"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function fetchAndRender(q, container) {
            fetch(`{{ route('pengaduan.search') }}?q=` + encodeURIComponent(q), {
                headers: { 'Accept': 'application/json' }
            }).then(r => r.json()).then(data => {
                renderItems(data, container);
            }).catch(() => renderItems([], container));
        }

        input.addEventListener('input', function () {
            const q = this.value.trim();
            clearTimeout(timer);
            timer = setTimeout(() => {
                if (q.length === 0) {
                    renderItems([]);
                    return;
                }
                fetchAndRender(q);
            }, 200);
        });

        input.addEventListener('keydown', function (e) {
            const items = suggestions.querySelectorAll('.result-item');
            if (!items.length) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                activeIndex = Math.min(activeIndex + 1, items.length - 1);
                updateActive(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                activeIndex = Math.max(activeIndex - 1, 0);
                updateActive(items);
            } else if (e.key === 'Enter') {
                const el = items[activeIndex];
                if (el) {
                    window.location = el.getAttribute('href');
                    e.preventDefault();
                }
            } else if (e.key === 'Escape') {
                renderItems([]);
            }
        });

        function updateActive(items) {
            items.forEach((it, i) => {
                if (i === activeIndex) {
                    it.classList.add('bg-slate-800');
                    it.scrollIntoView({ block: 'nearest' });
                } else {
                    it.classList.remove('bg-slate-800');
                }
            });
        }

        // click suggestions
        suggestions.addEventListener('click', function (e) {
            const a = e.target.closest('a');
            if (a) return; // normal navigation
        });

        document.addEventListener('click', function (e) {
            if (!suggestions.contains(e.target) && e.target !== input) {
                suggestions.classList.add('hidden');
            }
        });

        // Mobile toggle
        if (mobileToggle && mobileOverlay && mobileClose && mobileInput && mobileSuggestions) {
            mobileToggle.addEventListener('click', function () {
                mobileOverlay.classList.remove('hidden');
                mobileInput.focus();
            });

            mobileClose.addEventListener('click', function () {
                mobileOverlay.classList.add('hidden');
                mobileSuggestions.innerHTML = '';
            });

            mobileInput.addEventListener('input', function () {
                const q = this.value.trim();
                clearTimeout(timer);
                timer = setTimeout(() => {
                    if (q.length === 0) {
                        mobileSuggestions.innerHTML = '';
                        return;
                    }
                    fetchAndRender(q, mobileSuggestions);
                }, 200);
            });
        }
    })();
</script>
