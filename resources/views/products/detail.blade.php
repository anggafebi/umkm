@extends('layouts.app')


@php
    $productSlug = $product->slug;

    $demoSlug = match ($productSlug) {
        'website-toko-online-umkm' => 'kopi-umkm',
        'website-ecommerce-jersey' => 'goalgear-jersey',
        'pos-kasir-digital' => 'pos-kasir',
        'website-katalog-produk' => 'katalog-produk',
        'demo-toko-iphone-online' => 'iphone',
        'demo-toko-sepatu-online' => 'sepatu',
        default => null,
    };
@endphp


@section('title', $product->name.' | Produk')
@section('description', \Illuminate\Support\Str::limit($product->description, 155))

@section('content')
<section class="modern-section">
    <div class="container">
        <a href="{{ route('products.index') }}" class="detail-back-btn"><x-icon name="arrow-left" size="16" /> Kembali ke Produk</a>
        <div class="product-detail-card">
            <div class="product-detail-image">
                @if($product->image)
                    <img loading="lazy" decoding="async" src="{{ \App\Support\Media::url($product->image, 'images/placeholder.svg') }}" alt="{{ $product->name }}">
                @else
                    <div class="product-placeholder">{{ strtoupper(substr($product->name, 0, 1)) }}</div>
                @endif
            </div>
            <div class="product-detail-content">
                <span class="section-kicker">PRODUK DIGITAL</span>
                <h1>{{ $product->name }}</h1>
                <div class="product-price">{{ \App\Support\ProductPricing::label($product) }}</div>
                @if($product->price !== null && (float)$product->price > 0)<p class="form-hint">Harga awal. Total biaya dapat berubah sesuai fitur dan kebutuhan.</p>@endif
                <p>{{ $product->description }}</p>
                <div class="hero-actions product-detail-actions">
                    <a class="button-primary" href="{{ route('consultation', ['produk' => $product->slug]) }}">Tanyakan produk <x-icon name="arrow-right" size="17" /></a>
                    

@if($demoSlug)
    <a class="button-secondary"
       href="{{ route('demo.show', ['demo' => $demoSlug]) }}"
       target="_blank"
       rel="noopener noreferrer">

        
        @if($demoSlug === 'kopi-umkm')
            Demo Toko Online UMKM
        @elseif($demoSlug === 'goalgear-jersey')
            Demo E-Commerce Jersey
        @elseif($demoSlug === 'pos-kasir')
            Demo POS Kasir Digital
        @elseif($demoSlug === 'katalog-produk')
            Demo Website Katalog Produk
        @elseif($demoSlug === 'iphone')
            Demo Toko iPhone Online
        @elseif($demoSlug === 'sepatu')
            Demo Toko Sepatu Online
        @else
            Lihat Demo Interaktif
        @endif


        <x-icon name="arrow-up-right" size="17" />
    </a>
@endif


                </div>
                @if($demoSlug)
                    <p class="form-hint product-demo-note">Demo dapat dicoba langsung. Data pesanan dan transaksi pada demo tidak diproses secara nyata.</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
