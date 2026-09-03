<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConsultationController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/tentang-kami', function(){
    return view('about.index');
})->name('about');

Route::get('/layanan', [ServiceController::class,'index'])
    ->name('services.index');

Route::get('/layanan/{slug}', [ServiceController::class,'show'])
    ->name('services.show');

Route::get('/produk', [ProductController::class,'index'])
    ->name('products.index');

Route::get('/produk/{slug}', [ProductController::class,'show'])
    ->name('products.show');

Route::get('/portfolio', [PortfolioController::class,'index'])
    ->name('portfolio.index');

Route::get('/portfolio/{slug}', [PortfolioController::class,'show'])
    ->name('portfolio.show');

Route::get('/kontak', function(){
    return view('contact.index');
})->name('contact');

Route::post('/kontak',
    [ContactController::class,'store']
)->name('contact.store');

Route::get('/konsultasi', function(){
    return view('consultation.index');
})->name('consultation');

Route::post('/konsultasi',
    [ConsultationController::class,'store']
)->name('consultation.store');

// Additional routes
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/admin_crud.php';
require __DIR__.'/media.php';
