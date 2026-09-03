<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

public function index(Request $request)
{

$query = Product::query();


if($request->search){

$query->where(
'name',
'like',
'%'.$request->search.'%'
);

}


$products = $query->latest()->get();


return view(
'products.index',
compact('products')
);

}


public function show($slug)
{

$product = Product::where(
'slug',
$slug
)->firstOrFail();


return view(
'products.detail',
compact('product')
);

}

}