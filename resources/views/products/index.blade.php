@extends('layouts.app')

@section('content')

<h1>Katalog Produk</h1>

<form method="GET">

<input 
type="text"
name="search"
placeholder="Cari produk">

<button>
Cari
</button>

</form>


<div class="product-grid">

@foreach($products as $product)

<div class="card">

<h3>
{{ $product->name }}
</h3>

<p>
{{ $product->price }}
</p>

<a href="/produk/{{ $product->slug }}">
Detail
</a>

</div>

@endforeach

</div>

@endsection