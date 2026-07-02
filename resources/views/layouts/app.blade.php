<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SiPenKa') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-100">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(34,211,238,0.18),_transparent_30%),linear-gradient(135deg,_#020617_0%,_#0f172a_100%)]">
            <div class="flex min-h-screen flex-col lg:flex-row">
                <div data-sidebar-overlay class="fixed inset-0 z-40 hidden bg-slate-950/70 lg:hidden"></div>

                @include('layouts.partials.sidebar')

                <div class="flex-1">
                    @include('layouts.partials.topbar')

                    <main class="p-4 sm:p-6 lg:p-8">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toggle = document.querySelector('[data-sidebar-toggle]');
                const sidebar = document.querySelector('[data-sidebar]');
                const overlay = document.querySelector('[data-sidebar-overlay]');

                if (!toggle || !sidebar || !overlay) {
                    return;
                }

                const openSidebar = () => {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    overlay.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                };

                const closeSidebar = () => {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                };

                toggle.addEventListener('click', function () {
                    if (sidebar.classList.contains('translate-x-0')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });

                overlay.addEventListener('click', closeSidebar);
                window.addEventListener('resize', function () {
                    if (window.innerWidth >= 1024) {
                        closeSidebar();
                    }
                });
            });
        </script>
    </body>
</html>
