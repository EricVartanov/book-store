<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookRatingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index'])->name('home');

Route::get('/login/', [UserController::class, 'login'])->name('login');
Route::post('/login/', [UserController::class, 'loginPost']);

Route::middleware('auth')->group(function () {
    Route::post('/logout/', [UserController::class, 'logout'])->name('logout');
    Route::get('/dashboard/', [UserController::class, 'dashboard'])->name('dashboard');

    Route::resource('books', BookController::class);
    Route::resource('users', UserController::class);

    Route::post('/books/{book}/rating', [BookRatingController::class, 'store'])->name('books.rate');
})->where(['user' => '[a-zA-Z0-9]+']);

