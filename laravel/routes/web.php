<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\SocialController;

Route::get('/', function () {
    return view('welcome');
});

// Auth routes without redirection
Route::prefix('/')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('authenticate');
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('signup');
});

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Posts resourceful controller routes
    Route::resource('posts', PostController::class);

    // Comments routes
    Route::prefix('/comments')->as('comments.')->group(function () {
        // store comment route
        Route::post('/{post}', [CommentController::class, 'store'])->name('store');
    });

    // Replies routes
    Route::prefix('/replies')->as('replies.')->group(function () {
        // store reply route
        Route::post('/{comment}', [ReplyController::class, 'store'])->name('store');
    });
    
    Route::post('/like', [PostController::class, 'fetchLike']);
    Route::post('/like/{id}', [PostController::class, 'handleLike']);
    
    Route::post('/dislike', [PostController::class, 'fetchDislike']);
    Route::post('/dislike/{id}', [PostController::class, 'handleDislike']);

    #Facebook Login
    Route::get('/login/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider'])->name('redirecttoprovider');
    // Route::get('/login/facebook', [App\Http\Controllers\Auth\LoginController::class, 'loginWithFacebook']);
    Route::get('/login/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback']);

    Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    #Linkedin Login
    Route::get('/auth/linkedin', [SocialController::class, 'redirectToLinkedIn'])->name('auth.linkedin');
    Route::get('/auth/linkedin/callback', [SocialController::class, 'handleLinkedInCallback']);

});
