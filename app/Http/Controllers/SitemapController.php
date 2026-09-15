<?php
namespace App\Http\Controllers;
use App\Models\BlogPost;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\Service;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = collect([
            ['loc'=>route('home'),'lastmod'=>now()],
            ['loc'=>route('services.index'),'lastmod'=>now()],
            ['loc'=>route('products.index'),'lastmod'=>now()],
            ['loc'=>route('portfolio.index'),'lastmod'=>now()],
            ['loc'=>route('blog.index'),'lastmod'=>now()],
            ['loc'=>route('about'),'lastmod'=>now()],
            ['loc'=>route('contact'),'lastmod'=>now()],
        ]);
        Service::each(fn($x)=>$urls->push(['loc'=>route('services.show',$x->slug),'lastmod'=>$x->updated_at]));
        Product::each(fn($x)=>$urls->push(['loc'=>route('products.show',$x->slug),'lastmod'=>$x->updated_at]));
        Portfolio::each(fn($x)=>$urls->push(['loc'=>route('portfolio.show',$x->slug),'lastmod'=>$x->updated_at]));
        BlogPost::where('status','published')->whereNotNull('published_at')->where('published_at','<=',now())->each(fn($x)=>$urls->push(['loc'=>route('blog.show',$x->slug),'lastmod'=>$x->updated_at]));
        return response()->view('sitemap', compact('urls'))->header('Content-Type','application/xml');
    }
}
