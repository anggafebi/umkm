<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/login',
    [LoginController::class,'show']
);

Route::post('/login',
    [LoginController::class,'login']
);

Route::post('/logout',
    [LoginController::class,'logout']
);