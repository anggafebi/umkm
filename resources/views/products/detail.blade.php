@extends('layouts.app')

@section('title', $product->name)

@section('content')

<section class="modern-section">
    <div class="container">

        <div class="product-detail-card">

            <div class="product-detail-image">
                @if($product->image)
                    <img src="{{ asset('images/products/'.$product->image) }}" alt="{{ $product->name }}">
                @else
                    <div class="product-placeholder">
                        Produk
                    </div>
                @endif
            </div>

            <div class="product-detail-content">

                <h1>{{ $product->name }}</h1>

                <div class="product-price">
                    Rp {{ number_format($product->price,0,',','.') }}
                </div>

                <p>
                    {{ $product->description }}
                </p>

                <a class="nav-cta" href="/konsultasi">
                    Inquiry WhatsApp
                </a>

            </div>

        </div>

    </div>
</section>

@endsection
