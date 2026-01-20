<?php

use App\Livewire\Chat;
use App\Livewire\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::livewire('/posts', Post::class)->name('posts');
    Route::get('chat', Chat::class)->name('chat');
});
