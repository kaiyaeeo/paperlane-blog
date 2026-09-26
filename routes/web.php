<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;

// Halaman publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/tag/{tag:slug}', [BlogController::class, 'tag'])->name('blog.tag');
Route::get('/author/{user}', [ProfileController::class, 'show'])->name('profile.show');

// Area admin (harus login)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('posts', PostController::class);

    // Route komentar
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('likes.toggle');
    Route::post('/posts/{post}/bookmark', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';