@extends('layouts.app')
@section('title','Kontak')
@section('content')
<section class="page-hero">
<div class="container">
<span class="badge">Contact</span>
<h1>Konsultasi Bisnis</h1>
<p>Sampaikan kebutuhan digital bisnis Anda. Kami akan membantu menemukan solusi yang tepat.</p>
</div>
</section>

<section class="modern-section">
<div class="container contact-grid">
<div class="modern-card">
<h2>Hubungi Kami</h2>
<p>WhatsApp: 08000000000</p>
<p>Email: info@aditech.com</p>
<p>Lokasi: Indonesia</p>
</div>

<div class="modern-card">
<h2>Kirim Pesan</h2>
<form method="POST" action="/kontak" class="contact-form">
@csrf
<input name="name" placeholder="Nama">
<input name="phone" placeholder="WhatsApp">
<input name="email" placeholder="Email">
<textarea name="message" placeholder="Kebutuhan bisnis"></textarea>
<button class="nav-cta">Kirim Konsultasi</button>
</form>
</div>
</div>
</section>
@endsection
