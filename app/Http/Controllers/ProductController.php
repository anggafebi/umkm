<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\PublicContentFallbacks;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Product::query();

            if ($request->filled('search')) {
                $query->where('name', 'like', '%'.$request->string('search')->trim().'%');
            }

            $products = $query->latest()->paginate(12)->withQueryString();
        } catch (QueryException $exception) {
            $products = PublicContentFallbacks::products();

            if ($request->filled('search')) {
                $term = mb_strtolower((string) $request->string('search')->trim());
                $products = $products->filter(
                    fn ($product) => str_contains(mb_strtolower($product->name), $term)
                )->values();
            }

            $products = PublicContentFallbacks::paginate($products, 12)->withQueryString();
            $this->logFallback($exception);
        }

        return view('products.index', compact('products'));
    }

    public function show(string $slug)
    {
        try {
            $product = Product::where('slug', $slug)->firstOrFail();
        } catch (QueryException $exception) {
            $product = PublicContentFallbacks::findBySlug(PublicContentFallbacks::products(), $slug);
            abort_unless($product, 404);
            $this->logFallback($exception);
        }

        return view('products.detail', compact('product'));
    }

    private function logFallback(QueryException $exception): void
    {
        logger()->warning('Product data could not be loaded; static fallback content was used.', [
            'message' => $exception->getMessage(),
        ]);
    }
}
