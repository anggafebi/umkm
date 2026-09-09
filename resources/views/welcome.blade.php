@extends('layouts.app')

@section('title','Aditech Multisolusi UMKM | Solusi Digital Bisnis')
@section('description','Aditech membantu UMKM dan perusahaan membangun website, sistem informasi, dan solusi digital.')

@section('content')
<section class="hero">
    <div class="hero-content">
        <span class="badge">Digital Solution Partner</span>
        <h1>Bangun Website Profesional untuk Mengembangkan Bisnis Anda</h1>
        <p>Aditech Multisolusi UMKM membantu bisnis memiliki website modern, cepat, responsive, dan mudah dikembangkan.</p>
        <div class="hero-actions">
            <a href="/konsultasi" class="btn-primary">Konsultasi Gratis</a>
            <a href="/portfolio" class="btn-secondary">Lihat Portfolio</a>
        </div>
        <div class="stats">
            <div><strong>50+</strong><span>Project</span></div>
            <div><strong>30+</strong><span>Client</span></div>
            <div><strong>24/7</strong><span>Support</span></div>
        </div>
    </div>
    <div class="hero-image">
        <img src="{{ asset('images/hero/hero-mockup.png') }}" alt="Website Mockup">
    </div>
</section>

<section class="section">
<h2>Mengapa Memilih Aditech?</h2>
<div class="cards">
<div class="card"><h3>Desain Modern</h3><p>Tampilan profesional sesuai kebutuhan bisnis.</p></div>
<div class="card"><h3>Responsive</h3><p>Optimal di desktop, tablet, dan mobile.</p></div>
<div class="card"><h3>Support</h3><p>Pendampingan setelah website selesai.</p></div>
</div>
</section>

<section class="section">
<h2>Layanan Kami</h2>
<div class="cards">
<div class="card"><h3>Website Development</h3><p>Company profile, landing page, dan website bisnis.</p></div>
<div class="card"><h3>Sistem Informasi</h3><p>Aplikasi custom sesuai proses bisnis.</p></div>
<div class="card"><h3>Maintenance</h3><p>Perawatan dan pengembangan sistem.</p></div>
</div>
</section>

<section class="section pricing">
<h2>Paket Website</h2>
<div class="cards">
<div class="card"><h3>Starter</h3><p>Landing page profesional.</p></div>
<div class="card"><h3>Business</h3><p>Company profile + CMS.</p></div>
<div class="card"><h3>Enterprise</h3><p>Custom system dan dashboard.</p></div>
</div>
</section>

<section class="section">
<h2>FAQ</h2>
<div class="card"><p><b>Berapa lama pengerjaan?</b><br>Sesuaikan dengan kompleksitas project.</p></div>
<div class="card"><p><b>Apakah bisa custom?</b><br>Ya, kebutuhan dapat disesuaikan.</p></div>
</section>

<section class="cta">
<h2>Siap Mengembangkan Bisnis Digital Anda?</h2>
<a href="/konsultasi" class="btn-primary">Hubungi Kami</a>
</section>
@endsection
