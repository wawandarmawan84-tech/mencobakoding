<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#F8FAFC] text-[#0F172A] antialiased">
        <div class="flex min-h-screen items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="w-full max-w-lg rounded-[28px] border border-slate-200 bg-white/95 p-8 shadow-[0_20px_50px_rgba(15,23,42,0.08)] backdrop-blur-xl">
                <div class="mb-8 text-center">
                    <a href="{{ url('/') }}" class="inline-flex items-center justify-center text-3xl font-semibold tracking-tight text-slate-900">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        @yield('subtitle', 'Sistem pengaduan masyarakat — masuk untuk melanjutkan')
                    </p>
                </div>

                @yield('content')
            </div>
        </div>
    </body>
</html>
