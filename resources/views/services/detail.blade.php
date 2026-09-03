@extends('layouts.app')

@section('content')
<section class="service-detail-page">
<div class="service-detail-container">
<div class="service-hero-card">
<span class="service-label">Layanan Digital UMKM</span>
<h1>{{ $service->name }}</h1>
<p>{{ $service->description }}</p>
<a href="/konsultasi" class="service-cta">Konsultasi Sekarang</a>
</div>

<div class="service-section-grid">
<div class="service-info-card">
<h2>Target Pengguna</h2>
<p>UMKM, perusahaan, dan bisnis yang membutuhkan solusi digital untuk meningkatkan kredibilitas dan operasional.</p>
</div>
<div class="service-info-card">
<h2>Masalah Yang Diselesaikan</h2>
<ul>
<li>Pengelolaan bisnis masih manual.</li>
<li>Informasi bisnis belum tersampaikan dengan baik.</li>
<li>Belum memiliki sistem digital.</li>
</ul>
</div>
</div>

<div class="service-content-card">
<h2>Fitur Utama</h2>
<div class="feature-grid">
<div class="feature-item">Responsive Design</div>
<div class="feature-item">SEO Basic</div>
<div class="feature-item">Integrasi WhatsApp</div>
<div class="feature-item">Manajemen Konten</div>
</div>
</div>

<div class="service-content-card">
<h2>Teknologi</h2>
<div class="technology-list">
<span>Laravel</span><span>MySQL</span><span>HTML</span><span>CSS</span><span>JavaScript</span>
</div>
</div>

<div class="service-bottom-cta">
<h2>Siap Mengembangkan Bisnis Digital Anda?</h2>
<p>Konsultasikan kebutuhan website atau sistem bisnis Anda bersama kami.</p>
<a href="/konsultasi">Mulai Konsultasi</a>
</div>
</div>
</section>
@endsection
