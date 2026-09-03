@extends('layouts.app')
@section('title','Konsultasi Digital')
@section('content')
<section class="page-hero">
<div class="container">
<span class="badge">Consultation</span>
<h1>Konsultasi Kebutuhan Digital</h1>
<p>Ceritakan kebutuhan bisnis Anda. Kami membantu memilih solusi website dan sistem digital yang sesuai.</p>
</div>
</section>

<section class="modern-section consultation-section">
<div class="container consultation-grid">
<div class="modern-card">
<h2>Solusi yang Kami Bantu</h2>
<ul class="feature-list">
<li>Website Company Profile</li>
<li>Website Toko dan Katalog Produk</li>
<li>Landing Page Promosi</li>
<li>Sistem Informasi Bisnis</li>
<li>POS dan Sistem Pendukung Operasional</li>
</ul>
</div>
<div class="modern-card">
<h2>Form Konsultasi</h2>
<form method="POST" action="/konsultasi" class="contact-form">
@csrf
<input name="name" placeholder="Nama Lengkap">
<input name="phone" placeholder="WhatsApp">
<input name="email" placeholder="Email">
<textarea name="message" placeholder="Jelaskan kebutuhan bisnis Anda"></textarea>
<button class="nav-cta">Kirim Konsultasi</button>
</form>
</div>
</div>
</section>
@endsection
