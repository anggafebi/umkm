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
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PricingPackageController;
Route::prefix('admin')->group(function(){ Route::resource('testimonials', TestimonialController::class)->only(['index','store','destroy']); Route::resource('faqs', FaqController::class)->only(['index','store','destroy']); Route::resource('pricing', PricingPackageController::class)->only(['index','store','destroy']); });
