<?php
namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\Portfolio;
use App\Models\PricingPackage;
use App\Models\Product;
use App\Models\Service;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'services' => Service::latest()->take(6)->get(),
            'products' => Product::latest()->take(3)->get(),
            'portfolios' => Portfolio::latest()->take(6)->get(),
            'testimonials' => Testimonial::where('status', true)->latest()->take(8)->get(),
            'faqs' => Faq::where('status', true)->orderBy('order')->take(8)->get(),
            'pricingPackages' => PricingPackage::where('status', true)->latest()->take(4)->get(),
            'posts' => BlogPost::with('category')->where('status','published')->whereNotNull('published_at')->where('published_at','<=',now())->latest('published_at')->take(3)->get(),
        ]);
    }
}
