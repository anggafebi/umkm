<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolio = Portfolio::latest()->paginate(10);

        return view('admin.portfolio.index', compact('portfolio'));
    }

    public function store(Request $request)
    {
        Portfolio::create(
            $request->all()
        );

        return back();
    }

    public function destroy($id)
    {
        Portfolio::findOrFail($id)->delete();

        return back();
    }
}