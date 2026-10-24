<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
Route::get('/demo', fn () => redirect('/demo/index.html'))->name('demo.index');
Route::middleware('track')->group(function(){
    Route::get('/',[HomeController::class,'index'])->name('home');
    Route::view('/tentang-kami','about.index')->name('about');
    Route::get('/layanan',[ServiceController::class,'index'])->name('services.index'); Route::get('/layanan/{slug}',[ServiceController::class,'show'])->name('services.show');
    Route::get('/produk',[ProductController::class,'index'])->name('products.index'); Route::get('/produk/{slug}',[ProductController::class,'show'])->name('products.show');
    Route::get('/demo/{demo}', function($demo){
        $allowed = ['sepatu','iphone','toko-online','pos-kasir','katalog-produk','kopi-umkm','goalgear-jersey',];
        abort_unless(in_array($demo, $allowed), 404);
        return view('demos.show', ['demo'=>$demo]);
    })->name('demo.show');

    Route::get('/portfolio',[PortfolioController::class,'index'])->name('portfolio.index'); Route::get('/portfolio/{slug}',[PortfolioController::class,'show'])->name('portfolio.show');
    Route::get('/blog',[BlogController::class,'index'])->name('blog.index'); Route::get('/blog/{slug}',[BlogController::class,'show'])->name('blog.show');
    Route::view('/kontak','contact.index')->name('contact'); Route::view('/konsultasi','consultation.index')->name('consultation');
});
Route::post('/kontak',[ContactController::class,'store'])->name('contact.store');
Route::post('/konsultasi',[ConsultationController::class,'store'])->name('consultation.store');
Route::post('/newsletter',[NewsletterController::class,'store'])->name('newsletter.store');
Route::get('/sitemap.xml',[SitemapController::class,'index'])->name('sitemap');
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';