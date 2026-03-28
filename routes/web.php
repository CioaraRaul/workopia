<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index']);

Route::get('jobs/saved', function () {
    return 'Saved Jobs - Coming Soon';
})->name('jobs.saved');

Route::get('/login', function () {
    return 'Login - Coming Soon';
})->name('login');

Route::get('/register', function () {
    return 'Register - Coming Soon';
})->name('register');

Route::get('/dashboard', function () {
    return 'Dashboard - Coming Soon';
})->name('dashboard');

Route::resource('jobs', JobController::class);
