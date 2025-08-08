<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/2fa', [App\Http\Controllers\TwoFactorController::class, 'verifyPage'])->name('2fa.verify');
    Route::post('/2fa', [App\Http\Controllers\TwoFactorController::class, 'verifyCode'])->name('2fa.check');
    Route::get('/2fa/send', [App\Http\Controllers\TwoFactorController::class, 'sendCode'])->name('2fa.send');
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
})->name('logout');
