<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
Route::middleware('guest')->group(function(){
    Route::get('/daftar',[RegisterController::class,'show'])->name('register');
    Route::post('/daftar',[RegisterController::class,'store'])->name('register.submit');
    Route::get('/login',[LoginController::class,'show'])->name('login');
    Route::post('/login',[LoginController::class,'login'])->name('login.submit');
});
Route::post('/logout',[LoginController::class,'logout'])->middleware('auth')->name('logout');
