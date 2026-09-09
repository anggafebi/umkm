<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Aditech Multisolusi UMKM')</title>
    <meta name="description" content="@yield('description', 'Solusi website dan sistem digital untuk UMKM')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/css/premium.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-cleanup.css') }}">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/hero-layout-fix.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/hero-modern-visual.css') }}">
</head>
<body>

@include('layouts.navbar')

<main>
    @yield('content')
</main>

<a href="https://wa.me/6287848127894?text=Halo%20Aditech,%20saya%20ingin%20konsultasi%20website" class="whatsapp-floating">WhatsApp</a>

@include('layouts.footer')

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init({ duration: 800, once: true });</script>
<script src="{{ asset('assets/js/app.js') }}"></script>

</body>
</html>
