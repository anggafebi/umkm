<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>@yield('title', 'Aditech Multisolusi UMKM')</title>
<meta name="description" content="@yield('description', 'Solusi website dan sistem digital untuk UMKM')">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{ asset('assets/css/premium.css') }}">
</head>
<body>
<header class="header">
<nav class="navbar">
<div class="brand">Aditech Multisolusi <span></span></div>
<div class="nav-links">
<a href="/">Home</a>
<a href="/layanan">Layanan</a>
<a href="/portfolio">Portfolio</a>
<a href="/tentang-kami">Tentang</a>
<a href="/kontak">Kontak</a>
<a class="nav-cta" href="/konsultasi">Konsultasi</a>
</div>
</nav>
</header>
<main>@yield('content')</main>
<a href="https://wa.me/6287848127894?text=Halo%20Aditech,%20saya%20ingin%20konsultasi%20website" class="whatsapp-floating">WhatsApp</a>
<footer class="footer">
<p>Aditech Multisolusi UMKM</p>
<p>Solusi digital untuk pertumbuhan bisnis</p>
</footer>
<script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>