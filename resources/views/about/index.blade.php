@extends('layouts.app')
@section('title','Tentang Kami | '.($siteSettings['site_name'] ?? 'Aditech Multisolusi'))
@section('description','Profil, visi, misi, nilai perusahaan, dan kompetensi CV. Aditif Tekno Multisolusi.')
@section('content')
<section class="page-hero"><div class="container"><span class="section-kicker">TENTANG KAMI</span><h1>CV. Aditif Tekno Multisolusi</h1><p>Your Partner in Technology &amp; Integration</p></div></section>
<section class="modern-section"><div class="container about-grid">
<article class="about-card"><span class="section-kicker">PROFIL PERUSAHAAN</span><h2>Mitra solusi teknologi terpadu</h2><p>CV. Aditif Tekno Multisolusi (Aditech Multisolusi) merupakan perusahaan system integrator dan penyedia solusi Teknologi Informasi terpadu. Kami berfokus pada pengembangan aplikasi web dan mobile, pengadaan peralatan kantor, serta pembangunan infrastruktur digital.</p><p>Kami mendukung efisiensi, modernisasi, dan efektivitas manajemen pemerintahan, BUMN, maupun sektor swasta melalui layanan Business to Government (B2G) dan Business to Business (B2B).</p></article>
<article class="about-card"><span class="section-kicker">LAYANAN DAN PENDEKATAN</span><h2>Solusi yang mengikuti kebutuhan</h2><p>Aditech menyediakan layanan pengembangan website dan aplikasi, pengadaan barang dan jasa, serta integrasi sistem dan implementasi proyek. Kami mengedepankan analisis kebutuhan, keterbukaan proses, dan dukungan berkelanjutan.</p><a class="product-button" href="{{ route('services.index') }}">Lihat Layanan</a></article>
</div></section>
<section class="modern-section soft"><div class="container about-grid">
<article class="about-card"><span class="section-kicker">VISI KAMI</span><h2>Visi</h2><p>Menjadi mitra system integrator terpercaya dalam menyediakan solusi teknologi terpadu yang andal, adaptif, dan berkelanjutan.</p></article>
<article class="about-card"><span class="section-kicker">MISI KAMI</span><h2>Misi</h2><p>Mendorong efisiensi, modernisasi, dan keamanan sistem kerja sektor publik maupun swasta melalui penyediaan solusi digital, fasilitas kantor modern, serta layanan terintegrasi yang andal dan terpercaya.</p></article>
</div></section>
<section class="modern-section"><div class="container"><div class="section-heading"><span class="section-kicker">NILAI INTI PERUSAHAAN</span><h2>Nilai ATM</h2><p>Prinsip yang menjadi landasan Aditech Multisolusi dalam melayani kebutuhan pelanggan.</p></div>
<div class="grid-three"><article class="about-card"><span class="section-kicker">A</span><h3>Accountability &amp; Integrity</h3><p>Kejujuran, keterbukaan, dan tanggung jawab atas proses serta hasil pekerjaan.</p></article>
<article class="about-card"><span class="section-kicker">T</span><h3>Teamwork &amp; Trust</h3><p>Kerja sama yang solid, rasa saling percaya, dan komunikasi yang baik bersama pelanggan.</p></article>
<article class="about-card"><span class="section-kicker">M</span><h3>Mastery &amp; Improvement</h3><p>Peningkatan kompetensi dan penyempurnaan cara kerja secara berkelanjutan.</p></article></div></div></section>
<section class="modern-section soft"><div class="container"><div class="section-heading"><span class="section-kicker">KOMPETENSI DAN PENGALAMAN</span><h2>Ruang lingkup keahlian kami</h2><p>Bidang layanan dan pelaksanaan pekerjaan yang dijelaskan dalam profil perusahaan.</p></div>
<div class="grid-three"><article class="about-card"><h3>Website &amp; Aplikasi</h3><p>Perancangan, pengembangan, keamanan, dan pemeliharaan website serta aplikasi.</p></article>
<article class="about-card"><h3>Integrasi Sistem</h3><p>Perencanaan dan integrasi komponen teknologi untuk mendukung kebutuhan operasional.</p></article>
<article class="about-card"><h3>Implementasi Proyek</h3><p>Pelaksanaan, pengujian, hingga serah terima solusi yang sesuai kebutuhan pengguna.</p></article></div></div></section>
<section class="modern-section"><div class="container about-grid"><article class="about-card"><span class="section-kicker">TIM KAMI</span><h2>Tim di balik layanan Aditech</h2><p>Kami mengedepankan kolaborasi, komunikasi yang baik, dan tanggung jawab dalam proses perencanaan hingga serah terima pekerjaan.</p><p>Profil anggota tim akan ditampilkan setelah nama, peran, dan izin publikasi disetujui perusahaan.</p></article>
<article class="about-card"><span class="section-kicker">MULAI BERDISKUSI</span><h2>Butuh solusi untuk bisnis Anda?</h2><p>Ceritakan kebutuhan Anda agar tim dapat memahami ruang lingkup dan memberikan rekomendasi yang relevan.</p><a class="product-button" href="{{ route('consultation') }}">Konsultasikan Kebutuhan</a></article></div></section>
@endsection
