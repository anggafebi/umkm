<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ConsultationController;

Route::prefix('admin')->group(function(){

    Route::get('/dashboard',
        [DashboardController::class,'index']
    );

    Route::get('/consultations',
        [ConsultationController::class,'index']
    );

    Route::put('/consultations/{id}',
        [ConsultationController::class,'update']
    );

});