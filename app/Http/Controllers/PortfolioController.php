<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Support\PublicContentFallbacks;
use Illuminate\Database\QueryException;

class PortfolioController extends Controller
{
    public function index()
    {
        try {
            $portfolio = Portfolio::latest()->paginate(12);
        } catch (QueryException $exception) {
            $portfolio = PublicContentFallbacks::paginate(PublicContentFallbacks::portfolios(), 12);
            $this->logFallback($exception);
        }

        return view('portfolio.index', compact('portfolio'));
    }

    public function show(string $slug)
    {
        try {
            $item = Portfolio::where('slug', $slug)->firstOrFail();
        } catch (QueryException $exception) {
            $item = PublicContentFallbacks::findBySlug(PublicContentFallbacks::portfolios(), $slug);
            abort_unless($item, 404);
            $this->logFallback($exception);
        }

        return view('portfolio.detail', compact('item'));
    }

    private function logFallback(QueryException $exception): void
    {
        logger()->warning('Portfolio data could not be loaded; static fallback content was used.', [
            'message' => $exception->getMessage(),
        ]);
    }
}
