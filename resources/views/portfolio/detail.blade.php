@extends('layouts.app')

@section('title', $item->title . ' | Portfolio')

@section('content')

<section class="portfolio-detail">
    <div class="portfolio-container">

        <div class="portfolio-hero-card">
            <span class="portfolio-badge">Portfolio Project</span>
            <h1>{{ $item->title }}</h1>
            <p>{{ $item->description }}</p>

            <a href="/konsultasi" class="primary-btn">
                Konsultasikan Project Anda
            </a>
        </div>

        <div class="portfolio-content-grid">

            <div class="portfolio-info-card">
                <h2>Tentang Project</h2>
                <p>
                    Project ini dibuat untuk membantu bisnis memiliki solusi
                    digital yang lebih profesional, mudah digunakan, dan sesuai
                    dengan kebutuhan operasional.
                </p>
            </div>

            <div class="portfolio-info-card">
                <h2>Kategori</h2>
                <p>Website Development UMKM</p>
            </div>

        </div>

        <div class="portfolio-section-card">
            <h2>Fitur Utama</h2>
            <div class="feature-grid">
                <div class="feature-item">Responsive Website</div>
                <div class="feature-item">Database Integration</div>
                <div class="feature-item">Business Optimization</div>
            </div>
        </div>

        <div class="portfolio-section-card">
            <h2>Teknologi</h2>
            <div class="tech-list">
                <span>Laravel</span>
                <span>MySQL</span>
                <span>HTML</span>
                <span>CSS</span>
                <span>JavaScript</span>
            </div>
        </div>

    </div>
</section>

@endsection
