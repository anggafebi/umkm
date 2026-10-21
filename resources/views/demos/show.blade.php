@extends('layouts.app')

@php
    $demoMeta = [
        'sepatu' => [
            'title' => 'KICKSTART Supply — Toko Sepatu',
            'name' => 'Demo Toko Sepatu',
            'description' => 'Contoh toko sneakers dengan pencarian, filter kategori, keranjang belanja, pengaturan jumlah produk, dan simulasi checkout.',
        ],
        'iphone' => [
            'title' => 'FORME Select — Gadget Store',
            'name' => 'Demo Toko Gadget',
            'description' => 'Contoh etalase gadget dengan kategori produk, pencarian, keranjang belanja, dan alur checkout simulasi.',
        ],
        'toko-online' => [
            'title' => 'Rasa Ruma — Toko Online',
            'name' => 'Demo Toko Online',
            'description' => 'Contoh toko online UMKM dengan menu produk, filter, keranjang, serta formulir checkout yang dapat dicoba.',
        ],
        'pos-kasir' => [
            'title' => 'Kasirly — POS Kasir',
            'name' => 'Demo POS Kasir',
            'description' => 'Contoh sistem kasir dengan pencatatan transaksi, pilihan metode pembayaran, riwayat, dan ringkasan laporan dalam sesi demo.',
        ],
        'katalog-produk' => [
            'title' => 'Loka Studio — Katalog Produk',
            'name' => 'Demo Katalog Produk',
            'description' => 'Contoh katalog produk dengan pencarian, kategori, detail spesifikasi, dan fitur simpan produk favorit.',
        ],
    ];
    $meta = $demoMeta[$demo] ?? $demoMeta['toko-online'];
    $demoUrl = asset('demo/'.$demo.'/index.html');
@endphp

@section('title', $meta['title'].' | '.($siteSettings['site_name'] ?? 'Aditech Multisolusi'))
@section('description', $meta['description'])

@section('content')
<section class="demo-page-shell">
    <div class="container">
        <a href="{{ route('products.index') }}" class="detail-back-btn"><x-icon name="arrow-left" size="16" /> Kembali ke Produk</a>
        <div class="demo-page-head">
            <div>
                <span class="section-kicker">DEMO PRODUK INTERAKTIF</span>
                <h1>{{ $meta['name'] }}</h1>
                <p>{{ $meta['description'] }}</p>
            </div>
            <a class="button-primary" href="{{ $demoUrl }}" target="_blank" rel="noopener noreferrer">Buka di tab baru <x-icon name="arrow-up-right" size="17" /></a>
        </div>
        <div class="demo-frame-shell">
            <div class="demo-frame-toolbar">
                <span><span style="color:#22c55e">●</span> Pratinjau langsung · {{ strtoupper($demo) }}</span>
                <a href="{{ $demoUrl }}" target="_blank" rel="noopener noreferrer">Buka demo penuh <x-icon name="arrow-up-right" size="15" /></a>
            </div>
            <iframe
                class="demo-frame"
                data-demo-frame
                src="{{ $demoUrl }}"
                title="{{ $meta['name'] }} — pratinjau interaktif"
                loading="eager"
                referrerpolicy="strict-origin-when-cross-origin"
            ></iframe>
        </div>
        <p class="demo-note">Ini merupakan prototipe antarmuka untuk mencoba alur penggunaan. Data, checkout, dan transaksi pada demo tidak terhubung ke database, pembayaran, atau sistem operasional sungguhan.</p>
    </div>
</section>
@endsection

@push('head')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const frame = document.querySelector('[data-demo-frame]');
    if (!frame) return;
    const resizeFrame = () => {
        try {
            const doc = frame.contentDocument;
            if (!doc || !doc.documentElement) return;
            const contentHeight = Math.max(doc.documentElement.scrollHeight, doc.body ? doc.body.scrollHeight : 0);
            frame.style.height = Math.min(Math.max(contentHeight + 4, 900), 2200) + 'px';
        } catch (_) {
            frame.style.height = '1100px';
        }
    };
    frame.addEventListener('load', function () {
        resizeFrame();
        try {
            if ('ResizeObserver' in window && frame.contentDocument && frame.contentDocument.documentElement) {
                const observer = new ResizeObserver(resizeFrame);
                observer.observe(frame.contentDocument.documentElement);
            }
        } catch (_) { /* Keep the default height if observing the iframe is unavailable. */ }
    });
    resizeFrame();
});
</script>
@endpush
