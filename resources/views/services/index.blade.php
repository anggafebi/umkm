@extends('layouts.app')
@section('title','Layanan Kami')
@section('content')
<section class="page-hero">
<div class="container">
<span class="badge">Digital Solution</span>
<h1>Layanan Digital Untuk UMKM</h1>
<p>Kami membantu bisnis membangun identitas digital melalui website, sistem informasi, dan solusi teknologi yang sesuai kebutuhan.</p>
</div>
</section>

<section class="modern-section">
<div class="container">
<div class="grid-three">
@foreach($services as $service)
<div class="modern-card service-card">
<div class="service-icon">◎</div>
<h2>{{ $service->name }}</h2>
<p>{{ $service->description }}</p>
<a class="nav-cta" href="/layanan/{{ $service->slug }}">Lihat Detail</a>
</div>
@endforeach
</div>
</div>
</section>

<section class="cta">
<h2>Butuh solusi digital khusus?</h2>
<p>Konsultasikan kebutuhan bisnis Anda bersama tim Aditech.</p>
<a href="/konsultasi">Mulai Konsultasi</a>
</section>
@endsection
