<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SiPenKa') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-800">
        <div class="min-h-screen">
            <div class="flex min-h-screen flex-col lg:flex-row">
                @include('layouts.partials.sidebar')

                <div class="flex-1">
                    @include('layouts.partials.topbar')

                    <main class="p-4 sm:p-6 lg:p-8">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
