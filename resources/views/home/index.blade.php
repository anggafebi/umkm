@extends('layouts.app')

@section('title','Solusi Digital UMKM')

@section('content')
<section class="hero-premium">
<div class="hero-content">
<span class="badge">Website Development untuk UMKM</span>
<h1>Bangun Website Profesional untuk Mengembangkan Bisnis Anda</h1>
<p>Kami membantu UMKM memiliki website, katalog digital, dan sistem bisnis yang sesuai kebutuhan.</p>
<a href="/konsultasi">Konsultasi Sekarang</a>
</div>
</section>

<section class="section">
<h2>Layanan Digital</h2>
<div class="service-grid">
@foreach(['Website Company Profile','Website Toko / Produk','Landing Page','Website Katalog','Sistem Informasi UMKM','POS & Business System','Custom Website Sesuai Kebutuhan'] as $item)
<div class="card"><h3>{{ $item }}</h3><p>Solusi digital untuk membantu bisnis lebih mudah dikenal dan dikelola.</p></div>
@endforeach
</div>
</section>

<section class="section">
<h2>Alur Kerja</h2>
<div class="process">
@foreach(['Konsultasi','Analisis','Proposal','Development','Testing','Launching'] as $i => $item)
<div><strong>0{{ $i+1 }}</strong><br>{{ $item }}</div>
@endforeach
</div>
</section>

<section class="section">
<h2>Testimoni Klien</h2>
<div class="grid-three">
<div class="card"><h3>UMKM Kuliner</h3><p>Website membantu pelanggan mengenal produk lebih mudah.</p></div>
<div class="card"><h3>Bisnis Retail</h3><p>Katalog digital membuat informasi produk lebih rapi.</p></div>
<div class="card"><h3>Jasa Profesional</h3><p>Tampilan profesional meningkatkan kepercayaan pelanggan.</p></div>
</div>
</section>

<section class="cta">
<h2>Siap Membuat Website untuk Bisnis Anda?</h2>
<a href="/konsultasi">Mulai Konsultasi</a>
</section>
@endsection