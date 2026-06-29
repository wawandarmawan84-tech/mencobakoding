<?php

use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PengaduanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('kategori.')->group(function () {
    Route::resource('kategori', KategoriController::class)->except(['show']);
});

Route::get('/test', function () {
    return view('welcome');
});
