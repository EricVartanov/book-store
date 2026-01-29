<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Page/Home');
});

Route::get('/about', [PagesController::class, 'about'])->name('about');

Route::get('/profile', function () {
    return Inertia::render('Page/Profile');
})->name('profile');

Route::get('/dashboard', function () {
    return Inertia::render('Page/Dashboard');
})->name('dashboard');

Route::post('/contact', [ContactController::class, 'store'])->name('contact');

