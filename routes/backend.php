<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\System\indexController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout',  [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth.custom')->group(function () {
    Route::get('/home', [indexController::class, 'index'])->name('home');
});
