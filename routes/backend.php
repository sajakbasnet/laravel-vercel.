<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\System\indexController;
use App\Http\Controllers\TwoFactorController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout',  [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth.custom','2fa'])->group(function () {
   
    Route::get('/home', [indexController::class, 'index'])->name('home');
    Route::post('/2fa', function () {
        return redirect(route('home'));
    })->name('2fa');

});
