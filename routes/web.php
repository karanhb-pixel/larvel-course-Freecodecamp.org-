<?php

use App\Http\Controllers\ClapController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])
        ->name('dashboard');

Route::get('/category/{category}',[PostController::class,'category'])
    ->name('post.byCategory');

Route::get('/@{user:username}/{post:slug}',[PostController::class,'show'])
        ->name('post.show');

Route::get('/@{user:username}',[PublicProfileController::class,'show'])
    ->name('profile.show');



Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/post/create', [PostController::class, 'create'])
        ->name('post.create');

    Route::get('/post/{post:slug}', [PostController::class, 'edit'])
        ->name('post.edit');

    Route::put('/post/{post}', [PostController::class, 'update'])
        ->name('post.update');

    Route::post('/post/create', [PostController::class, 'store'])
        ->name('post.store');

    Route::delete('/post/{post}', [PostController::class, 'destroy'])
        ->name('post.destroy');

    Route::get('/my-posts', [PostController::class, 'myPosts'])
        ->name('post.myPosts');

    Route::post('/follow/{user}',[FollowController::class,'followUnfollow'])
        ->name('follow');

    Route::get('/following/@{user:username}',[PostController::class,'indexByFollowing'])
    ->name('post.byFollowing');

    Route::post('/clap/{post}',[ClapController::class,'clap'])
        ->name('clap');

});



Route::middleware('auth')
    ->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])
            ->name('profile.destroy');
    });

require __DIR__.'/auth.php';
