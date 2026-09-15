<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolio = Portfolio::latest()->paginate(12);

        return view(
            'portfolio.index',
            compact('portfolio')
        );
    }

    public function show($slug)
    {
        $item = Portfolio::where(
            'slug',
            $slug
        )->firstOrFail();

        return view(
            'portfolio.detail',
            compact('item')
        );
    }
}