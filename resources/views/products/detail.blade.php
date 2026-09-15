@extends('layouts.app')
@section('title',$product->name.' | Produk')
@section('description',\Illuminate\Support\Str::limit($product->description,155))
@section('content')
<section class="modern-section"><div class="container"><a href="{{ route('products.index') }}" class="detail-back-btn">← Kembali ke Produk</a><div class="product-detail-card"><div class="product-detail-image">@if($product->image)<img loading="lazy" decoding="async" src="{{ \App\Support\Media::url($product->image, 'images/placeholder.svg') }}" alt="{{ $product->name }}">@else<div class="product-placeholder">{{ strtoupper(substr($product->name,0,1)) }}</div>@endif</div><div class="product-detail-content"><span class="section-kicker">DIGITAL PRODUCT</span><h1>{{ $product->name }}</h1><div class="product-price">{{ $product->price!==null?'Rp '.number_format($product->price,0,',','.'):'Hubungi kami' }}</div><p>{{ $product->description }}</p><a class="button-primary" href="{{ route('consultation') }}">Tanyakan Produk</a></div></div></div></section>
@endsection
