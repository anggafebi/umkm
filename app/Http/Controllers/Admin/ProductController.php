<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function store(Request $request)
    {
        Product::create(
            $request->validate([
                'name'=>'required',
                'price'=>'nullable'
            ])
        );

        return back();
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return back();
    }
}