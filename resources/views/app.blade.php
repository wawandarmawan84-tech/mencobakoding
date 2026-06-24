<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Pengaduan Masyarakat') }}</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
        <header class="border-b border-slate-200 bg-white/95 backdrop-blur-sm">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-red-600 text-white shadow-sm">
                        <span class="font-semibold">PM</span>
                    </div>
                    <div>
                        <a href="{{ url('/') }}" class="text-lg font-semibold text-slate-900 hover:text-red-600">
                            {{ config('app.name', 'Pengaduan Masyarakat') }}
                        </a>
                        <p class="text-sm text-slate-500">Sistem pengaduan masyarakat untuk pelayanan publik</p>
                    </div>
                </div>
                <nav class="flex items-center gap-4 text-sm text-slate-600">
                    <a href="{{ url('/') }}" class="transition hover:text-slate-900">Beranda</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-full bg-slate-900 px-4 py-2 text-white transition hover:bg-slate-700">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-full border border-slate-300 px-4 py-2 transition hover:border-slate-400">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-full bg-red-600 px-4 py-2 text-white transition hover:bg-red-500">Daftar</a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            @hasSection('page-heading')
                <header class="mb-8">
                    <h1 class="text-3xl font-semibold text-slate-900">@yield('page-heading')</h1>
                    @hasSection('page-description')
                        <p class="mt-2 text-sm text-slate-600">@yield('page-description')</p>
                    @endif
                </header>
            @endif

            @yield('content')
        </main>

        <footer class="border-t border-slate-200 bg-white/95 py-6">
            <div class="mx-auto max-w-7xl px-4 text-sm text-slate-500 sm:px-6 lg:px-8">
                <p class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                    <span>&copy; {{ date('Y') }} {{ config('app.name', 'Pengaduan Masyarakat') }}.</span>
                    <span>Dirancang sebagai sistem pengaduan masyarakat.</span>
                </p>
            </div>
        </footer>

        @stack('scripts')
    </body>
</html>
