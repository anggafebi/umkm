<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\Service;
use App\Support\PublicContentFallbacks;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = collect([
            ['loc' => route('home'), 'lastmod' => now()],
            ['loc' => route('services.index'), 'lastmod' => now()],
            ['loc' => route('products.index'), 'lastmod' => now()],
            ['loc' => route('portfolio.index'), 'lastmod' => now()],
            ['loc' => route('blog.index'), 'lastmod' => now()],
            ['loc' => route('about'), 'lastmod' => now()],
            ['loc' => route('contact'), 'lastmod' => now()],
        ]);

        try {
            $services = Service::all();
            $products = Product::all();
            $portfolios = Portfolio::all();
            $posts = BlogPost::where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->get();
        } catch (QueryException $exception) {
            $services = PublicContentFallbacks::services();
            $products = PublicContentFallbacks::products();
            $portfolios = PublicContentFallbacks::portfolios();
            $posts = PublicContentFallbacks::posts();

            logger()->warning('Sitemap data could not be loaded; static fallback content was used.', [
                'message' => $exception->getMessage(),
            ]);
        }

        $this->appendEntries($urls, $services, 'services.show');
        $this->appendEntries($urls, $products, 'products.show');
        $this->appendEntries($urls, $portfolios, 'portfolio.show');
        $this->appendEntries($urls, $posts, 'blog.show');

        return response()
            ->view('sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }

    private function appendEntries(Collection $urls, Collection $items, string $routeName): void
    {
        foreach ($items as $item) {
            $urls->push([
                'loc' => route($routeName, $item->slug),
                'lastmod' => $item->updated_at ?? $item->published_at ?? now(),
            ]);
        }
    }
}
