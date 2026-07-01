<aside data-sidebar class="fixed inset-y-0 left-0 z-50 w-72 -translate-x-full transform bg-slate-900 text-slate-100 transition duration-300 ease-in-out lg:static lg:w-72 lg:min-h-screen lg:translate-x-0">
    <div class="flex items-center justify-between border-b border-slate-800 px-6 py-5">
        <div>
            <p class="text-lg font-semibold">SiPenKa</p>
            <p class="text-sm text-slate-400">Kelurahan Konoha</p>
        </div>
        <div class="rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-medium text-emerald-300">
            Online
        </div>
    </div>

    <nav class="space-y-1 px-3 py-4">
        @php
            $menu = [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'url' => route('dashboard'), 'icon' => '◉'],
                ['label' => 'Pengaduan', 'route' => 'pengaduan.*', 'url' => url('/pengaduan'), 'icon' => '◌'],
                ['label' => 'Kategori', 'route' => 'admin.kategori.*', 'url' => url('/admin/kategori'), 'icon' => '◎'],
                ['label' => 'Profil', 'route' => 'profile', 'url' => url('/profile'), 'icon' => '◍'],
            ];
        @endphp

        @foreach ($menu as $item)
            @php
                $isActive = request()->routeIs($item['route']);
            @endphp

            <a href="{{ $item['url'] }}"
               class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition {{ $isActive ? 'bg-emerald-500 text-white shadow' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span class="text-base">{{ $item['icon'] }}</span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>
</aside>
