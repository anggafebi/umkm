<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PortfolioController;

Route::prefix('admin')->group(function(){

    Route::resource('services', ServiceController::class)
        ->only(['index','store','destroy']);

    Route::resource('products', ProductController::class)
        ->only(['index','store','destroy']);

    Route::resource('portfolio', PortfolioController::class)
        ->only(['index','store','destroy']);

});