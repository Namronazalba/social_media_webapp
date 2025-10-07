<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FriendshipController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('/users', [FriendshipController::class, 'index'])->name('friends.index');
    Route::post('/friends/{id}', [FriendshipController::class, 'addFriend'])->name('friends.add');
    Route::get('/users/{id}', [FriendshipController::class, 'showProfile'])->name('friends.profile');

    Route::get('/friends/requests', [FriendshipController::class, 'requests'])->name('friends.requests');
    Route::post('/friends/{id}/accept', [FriendshipController::class, 'accept'])->name('friends.accept');
    Route::post('/friends/{id}/ignore', [FriendshipController::class, 'ignore'])->name('friends.ignore');
    Route::delete('/friends/{id}/cancel', [FriendshipController::class, 'cancel'])->name('friends.cancel');

    Route::get('/friends/list', [FriendshipController::class, 'friendsList'])->name('friends.list');
    Route::get('/friends/{id}', [FriendshipController::class, 'show'])->name('friends.profile');



});

require __DIR__.'/auth.php';
