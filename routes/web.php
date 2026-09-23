<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController; // Tambahkan ini
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Tambahkan route ini (hanya untuk user yang login)
Route::resource('posts', PostController::class)->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';