@extends('layouts.app')

@section('content')

<section class="page-hero">
    <div class="container">
        <span class="badge">Portfolio</span>
        <h1>Project Digital Kami</h1>
        <p>Kumpulan solusi digital yang kami kembangkan untuk membantu bisnis mengelola dan meningkatkan kehadiran online.</p>
    </div>
</section>

<section class="modern-section">
    <div class="container">
        <div class="portfolio-grid-modern">
            @foreach($portfolio as $item)
            <div class="portfolio-card">
                <div class="portfolio-image">
                    <div class="portfolio-placeholder">{{ strtoupper(substr($item->title,0,1)) }}</div>
                </div>
                <div class="portfolio-content">
                    <span class="portfolio-tag">Digital Solution</span>
                    <h3>{{ $item->title }}</h3>
                    <p>{{ $item->description }}</p><small>Fitur: Responsive Design, WhatsApp Integration, Digital Catalog</small>
                    <a class="portfolio-button" href="/portfolio/{{ $item->slug }}">Lihat Detail</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="cta">
    <h2>Punya ide bisnis digital?</h2>
    <p>Konsultasikan kebutuhan website dan sistem bisnis Anda bersama kami.</p>
    <a href="/konsultasi">Konsultasi Sekarang</a>
</section>

@endsection