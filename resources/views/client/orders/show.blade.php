@extends('layouts.app')

@section('title', 'Detail ' . $order->order_number . ' | Aditech')

@push('head')
    <link rel="stylesheet" href="{{ asset('assets/css/client.css') }}">
@endpush

@section('content')
    <section class="page-hero">
        <div class="container">
            <span class="section-kicker">DETAIL PESANAN</span>
            <h1>{{ $order->order_number }}</h1>
            <p>{{ $order->product_name }}</p>
        </div>
    </section>

    <section class="modern-section">
        <div class="container client-area">
            @include('client.partials.navigation')

            @if (session('success'))
                <div class="form-success">{{ session('success') }}</div>
            @endif

            <div class="modern-card">
                <h2>Informasi pesanan</h2>
                <p><strong>Jenis:</strong> {{ $order->order_type === 'fixed' ? 'Checkout harga tetap' : 'Pengajuan custom' }}</p>
                <p><strong>Status:</strong> {{ str_replace('_', ' ', $order->status) }}</p>
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                <p><strong>Produk / layanan:</strong> {{ $order->product_name }}</p>

                @if ($order->price)
                    <p><strong>Harga:</strong> Rp{{ number_format((float) $order->price, 0, ',', '.') }}</p>
                @endif

                @if ($order->project_name)
                    <p><strong>Nama proyek:</strong> {{ $order->project_name }}</p>
                @endif

                @if ($order->description)
                    <p><strong>Deskripsi:</strong><br>{{ $order->description }}</p>
                @endif

                @if ($order->requested_features)
                    <p><strong>Fitur:</strong><br>{{ $order->requested_features }}</p>
                @endif

                @if ($order->client_notes)
                    <p><strong>Catatan:</strong><br>{{ $order->client_notes }}</p>
                @endif
            </div>

            @if ($order->order_type === 'custom' && $order->offer_price)
                <div class="modern-card">
                    <h2>Penawaran Admin</h2>
                    <h3>Rp{{ number_format((float) $order->offer_price, 0, ',', '.') }}</h3>
                    <p style="white-space: pre-wrap">{{ $order->offer_details }}</p>

                    @if ($order->status === 'awaiting_approval')
                        <form method="POST" action="{{ route('client.orders.respond', $order) }}" class="hero-actions">
                            @csrf
                            <button class="button-primary" name="decision" value="accept">Setujui Penawaran</button>
                            <button class="button-secondary" name="decision" value="revision">Minta Revisi</button>
                        </form>
                    @endif
                </div>
            @endif

            <p class="form-hint">
                Tahap ini belum mencakup pembayaran online. Admin akan menghubungi Anda untuk tindak lanjut sesuai status pesanan.
            </p>
        </div>
    </section>
@endsection
