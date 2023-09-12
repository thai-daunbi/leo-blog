<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReplyController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// routes/web.php

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('login');

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
});

//Schedule
Route::resource('/schedule', App\Http\Controllers\ScheduleController::class);
Route::get('/api/get-events', [App\Http\Controllers\ScheduleController::class, 'getEvents']);
Route::get('/edit-schedule/{id}', [App\Http\Controllers\ScheduleController::class, 'editSchedule'])->name('edit-schedule');
Route::post('/update-schedule/{id}', [App\Http\Controllers\ScheduleController::class, 'updateSchedule'])->name('update-schedule');