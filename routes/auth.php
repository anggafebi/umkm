<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
Route::middleware('guest')->group(function(){
    Route::get('/login',[LoginController::class,'show'])->name('login');
    Route::post('/login',[LoginController::class,'login'])->name('login.submit');
});
Route::post('/logout',[LoginController::class,'logout'])->middleware('auth')->name('logout');
