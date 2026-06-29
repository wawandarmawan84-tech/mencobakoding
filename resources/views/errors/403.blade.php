<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Unauthorized</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 flex items-center justify-center px-4">
    <div class="max-w-xl w-full bg-white shadow-lg rounded-3xl border border-slate-200 p-8 text-center">
        <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-rose-100 text-rose-600 mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728" />
            </svg>
        </span>
        <h1 class="text-4xl font-semibold mb-4">403</h1>
        <p class="text-slate-600 mb-6">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-3">
            <button type="button" onclick="window.history.back()" class="px-5 py-3 rounded-xl bg-slate-900 text-white hover:bg-slate-700 transition">Kembali</button>
            <a href="{{ url('/') }}" class="px-5 py-3 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 transition">Beranda</a>
        </div>
    </div>
</body>
</html>
