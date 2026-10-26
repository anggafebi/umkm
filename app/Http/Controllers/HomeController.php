<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\Portfolio;
use App\Models\PricingPackage;
use App\Models\Product;
use App\Models\Service;
use App\Models\Testimonial;
use App\Support\PublicContentFallbacks;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'services' => collect(),
            'products' => collect(),
            'portfolios' => collect(),
            'testimonials' => collect(),
            'faqs' => collect(),
            'pricingPackages' => collect(),
            'posts' => collect(),
            'serviceCount' => 7,
            'productCount' => 5,
            'portfolioCount' => 2,
        ];

        try {
            $data = [
                'services' => Service::latest()->take(6)->get(),
                'products' => Product::latest()->get(),
                'portfolios' => Portfolio::latest()->take(4)->get(),
                'testimonials' => Testimonial::where('status', true)->latest()->take(8)->get(),
                'faqs' => Faq::where('status', true)->orderBy('order')->take(8)->get(),
                'pricingPackages' => PricingPackage::where('status', true)->latest()->take(4)->get(),
                'posts' => BlogPost::with('category')
                    ->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now())
                    ->latest('published_at')
                    ->take(3)
                    ->get(),
                'serviceCount' => Service::count(),
                'productCount' => Product::count(),
                'portfolioCount' => Portfolio::count(),
            ];
        } catch (\Throwable $exception) {
            $data['services'] = PublicContentFallbacks::services()->take(6);
            $data['products'] = PublicContentFallbacks::products();
            $data['portfolios'] = PublicContentFallbacks::portfolios()->take(4);
            $data['posts'] = PublicContentFallbacks::posts()->take(3);

            logger()->warning('Homepage data could not be loaded; static fallback content was used.', [
                'message' => $exception->getMessage(),
            ]);
        }

        return view('home.index', $data);
    }
}
