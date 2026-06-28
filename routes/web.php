<?php

use App\Http\Controllers\Admin\KategoriController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->name('kategori.')->group(function () {
    Route::resource('kategori', KategoriController::class);
});

Route::get('/test', function () {
    return view('welcome');
});
