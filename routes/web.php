<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
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
Route::get('/gest',[App\Http\Controllers\GestController::class,'index'])->name('gest');

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [\Chatify\Http\Controllers\MessagesController::class, 'index'])
        ->name('chat');
});
Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
// ...existing code...
Route::get('/guest', [App\Http\Controllers\GuestController::class, 'index'])->name('guest.index');
