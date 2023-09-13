<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//post
Route::get('/admin/pages', [App\Http\Controllers\PostlistController::class, 'index'])->name('postlist.index');
Route::get('/posts/{post}/edit', [App\Http\Controllers\PostlistController::class, 'edit'])->name('edit-post');
Route::put('/posts/{post}', [App\Http\Controllers\PostlistController::class, 'update']);
//post-update
Route::get('/posts/{postId}/toggle-visibility', [App\Http\Controllers\PostlistController::class,'toggleVisibility'])->name('post.toggle-visibility');



Route::middleware(['auth', 'admin'])->group(function () {
    Route::patch('user/{user}/toggle_activation', 'UserController@toggleActivation')->name('user.toggle_activation');
});


// profile setting
Route::middleware(['auth'])->group(function () {
    Route::get('admin/settings', [App\Http\Controllers\ProfileController::class, 'settings']);
});

Route::get('/admin/settings', [App\Http\Controllers\ProfileController::class, 'index'])->name('settings');
//profile-edit
Route::get('/admin/settings/edit-user/{id}', [App\Http\Controllers\ProfileController::class, 'editUser'])->name('edit-user');
Route::post('edit-account-info',  [App\Http\Controllers\ProfileController::class,'accountInfoStore'])->name('admin.account.info.store');
Route::post('change-password',  [App\Http\Controllers\ProfileController::class,'changePasswordStore'])->name('admin.account.password.store');
//profile-status
Route::get('/deactivate-user/{id}', [App\Http\Controllers\ProfileController::class, 'deactivateUser'])->name('deactivate-user');
Route::get('/activate-user/{id}', [App\Http\Controllers\ProfileController::class, 'activateUser'])->name('activate-user');


Route::resource('/schedule', App\Http\Controllers\ScheduleController::class);

Route::get('/add-event', function () {
    return view('schedule/add-event');
});

Route::put('/api/save-event', [App\Http\Controllers\ScheduleController::class, 'saveEvent']);

Route::get('/api/get-events', [App\Http\Controllers\ScheduleController::class, 'getEvents']);

Route::post('/save-event', [App\Http\Controllers\ScheduleController::class, 'saveEvent']);
Route::get('/edit-schedule/{id}', [App\Http\Controllers\ScheduleController::class, 'editSchedule'])->name('edit-schedule');
Route::post('/update-schedule/{id}', [App\Http\Controllers\ScheduleController::class, 'updateSchedule'])->name('update-schedule');
Route::get('/edit-schedule2/{id}', [App\Http\Controllers\ScheduleController::class, 'editSchedule2'])->name('edit-schedule2');

Route::put('/schedule/update/{id}', [App\Http\Controllers\ScheduleController::class, 'updateSchedule'])->name('update-schedule');
Route::delete('/schedule/{id}', [App\Http\Controllers\ScheduleController::class, 'deleteSchedule'])->name('delete-schedule');

Route::put('/schedule/update2/{id}', [App\Http\Controllers\ScheduleController::class, 'updateSchedule2'])->name('update-schedule2');


