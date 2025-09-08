<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GuestController;
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
Route::get('/events', [App\Http\Controllers\EventController::class, 'index'])->name('events.index');
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [\Chatify\Http\Controllers\MessagesController::class, 'index'])
        ->name('chat');
});
Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
Route::get('/posts/post_event', [App\Http\Controllers\PostController::class, 'post_event'])->name('posts.post_event');
Route::get('/posts/create', [App\Http\Controllers\PostController::class, 'create'])->name('posts.create');
Route::get('/posts/{id}/edit', [App\Http\Controllers\PostController::class, 'edit'])->name('posts.edit');
Route::get('/posts/{id}', [App\Http\Controllers\PostController::class, 'show'])->name('posts.show');
// ...existing code...
Route::get('/guest', [App\Http\Controllers\GuestController::class, 'index'])->name('guest.index');

Route::get('/events/guest', [App\Http\Controllers\EventController::class, 'index'])->name('events.guest_index');

Route::get('/mypage', [UserController::class, 'mypage'])->name('users.mypage');

Route::patch('/profile/update', [UserController::class, 'update'])->name('profile.update');
