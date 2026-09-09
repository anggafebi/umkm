@extends('layouts.app')

@section('title', 'Produk UMKM | Aditech Multisolusi')

@section('content')

<section class="page-hero">
    <div class="container">
        <h1>Katalog Produk</h1>
        <p>Pilih produk digital dan solusi bisnis yang sesuai dengan kebutuhan usaha Anda.</p>
    </div>
</section>

<section class="modern-section">
    <div class="container">

        <form method="GET" class="product-search">
            <input 
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari produk...">

            <button class="nav-cta">
                Cari
            </button>
        </form>

        <div class="product-grid-modern">

            @forelse($products as $product)

            <article class="product-card">

                <div class="product-image">
                    @if($product->image)
                        <img src="{{ asset('images/products/'.$product->image) }}" alt="{{ $product->name }}">
                    @else
                        <div class="product-placeholder">
                            Produk
                        </div>
                    @endif
                </div>

                <div class="product-content">
                    <h3>{{ $product->name }}</h3>

                    <p class="product-description">
                        {{ Str::limit($product->description, 120) }}
                    </p>

                    <div class="product-footer">
                        <strong>
                            Rp {{ number_format($product->price,0,',','.') }}
                        </strong>

                        <a class="product-button" href="/produk/{{ $product->slug }}">
                            Lihat Detail
                        </a>
                    </div>
                </div>

            </article>

            @empty

            <div class="empty-product">
                Produk belum tersedia.
            </div>

            @endforelse

        </div>

    </div>
</section>

@endsection
