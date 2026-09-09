@extends('layouts.app')

@section('title','Aditech Multisolusi UMKM | Website Profesional untuk Bisnis')
@section('description','Jasa pembuatan website profesional, katalog digital, dan sistem bisnis untuk UMKM.')

@section('content')
<section class="hero-premium reveal">
<div class="hero-content">
<span class="badge">Digital Solution Partner UMKM</span>
<h1>Website Profesional untuk Membantu Bisnis Anda Tumbuh</h1>
<p>Kami membangun website modern, katalog digital, dan sistem bisnis yang mudah digunakan serta siap berkembang.</p>
<div class="hero-actions">
<a class="btn-primary" href="/konsultasi">Konsultasi Gratis</a>
<a class="btn-secondary" href="/portfolio">Lihat Portfolio</a>
</div>
<div class="stats">
<div><strong>50+</strong><span>Project</span></div>
<div><strong>98%</strong><span>Kepuasan</span></div>
<div><strong>24/7</strong><span>Support</span></div>
</div>
</div>
<div class="hero-image"><img src="{{ asset('images/hero/hero-mockup.png') }}" alt="Aditech digital solution mockup"></div>
</section>

<section class="section reveal">
<h2>Mengapa Memilih Kami?</h2>
<div class="grid-four">
@foreach(['Desain Modern','Responsive Mobile','SEO Friendly','Support Berkelanjutan'] as $item)
<div class="card"><h3>{{ $item }}</h3><p>Solusi digital yang dirancang sesuai kebutuhan bisnis.</p></div>
@endforeach
</div>
</section>

<section class="section reveal">
<h2>Layanan Digital</h2>
<div class="service-grid">
@foreach(['Website Company Profile','Website Toko / Produk','Landing Page','Website Katalog','Sistem Informasi UMKM','POS & Business System'] as $item)
<div class="card"><h3>{{ $item }}</h3><p>Pembuatan sistem digital profesional untuk meningkatkan operasional bisnis.</p></div>
@endforeach
</div>
</section>

<section class="section reveal">
<h2>Paket Website</h2>
<div class="pricing-grid">
@foreach([['Starter','Landing Page'],['Business','Company Profile + CMS'],['Professional','Custom System']] as $item)
<div class="card pricing"><h3>{{ $item[0] }}</h3><p>{{ $item[1] }}</p><a href="/konsultasi">Diskusikan</a></div>
@endforeach
</div>
</section>


<section class="section reveal">
<h2>Proses Kerja Kami</h2>
<div class="grid-four">
<div class="card"><h3>1. Konsultasi</h3><p>Memahami kebutuhan dan tujuan bisnis.</p></div>
<div class="card"><h3>2. Perancangan</h3><p>Membuat desain dan struktur website.</p></div>
<div class="card"><h3>3. Development</h3><p>Membangun website yang cepat dan aman.</p></div>
<div class="card"><h3>4. Launching</h3><p>Website siap digunakan dan dikembangkan.</p></div>
</div>
</section>

<section class="section reveal">
<h2>Portfolio</h2>
<div class="grid-three">
@for($i=1;$i<=3;$i++)
<div class="card image-card"><img src="{{ asset('images/portfolio/project-'.$i.'.jpg') }}" alt="Portfolio project {{ $i }}"><h3>Project Website {{ $i }}</h3><p>Website profesional dengan desain responsive.</p></div>
@endfor
</div>
</section>

<section class="section reveal">
<h2>Testimoni</h2>
<div class="grid-three">
<div class="card"><h3>UMKM Kuliner</h3><p>Website membantu pelanggan menemukan produk dengan lebih mudah.</p></div>
<div class="card"><h3>Retail</h3><p>Katalog digital membuat informasi produk lebih profesional.</p></div>
<div class="card"><h3>Jasa Profesional</h3><p>Tampilan digital meningkatkan kredibilitas bisnis.</p></div>
</div>
</section>

<section class="section reveal">
<h2>FAQ</h2>
<div class="faq">
<details><summary>Berapa lama pembuatan website?</summary><p>Estimasi 7 sampai 30 hari tergantung kompleksitas.</p></details>
<details><summary>Apakah bisa custom desain?</summary><p>Bisa, desain dapat disesuaikan dengan kebutuhan bisnis.</p></details>
</div>
</section>

<section class="cta reveal">
<h2>Siap Membuat Website untuk Bisnis Anda?</h2>
<a href="/konsultasi">Mulai Konsultasi</a>
</section>
@endsection
