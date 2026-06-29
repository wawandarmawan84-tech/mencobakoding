<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Ubah Password</h2>
                <p class="mt-2 text-sm text-gray-600">Masukkan password lama dan password baru Anda</p>
            </div>

            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Password Lama</label>
                    <input id="current_password" name="current_password" type="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('current_password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input id="password" name="password" type="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Simpan Password Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
