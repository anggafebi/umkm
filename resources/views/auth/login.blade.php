<!DOCTYPE html>
<html lang="id" class="theme-preload">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex,nofollow">
    <title>Login Admin | {{ $siteSettings['site_name'] ?? 'Aditech' }}</title>
    <script>(()=>{const s=localStorage.getItem('aditech-theme');const t=['light','dark'].includes(s)?s:(matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light');document.documentElement.dataset.theme=t;document.documentElement.style.colorScheme=t})();</script>
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>
<body class="login-page">
<div class="login-shell">
    <section class="login-brand-panel" aria-label="Tentang admin console">
        <a href="{{ route('home') }}" class="admin-brand"><img src="{{ \App\Support\Media::url($siteSettings['logo_path'] ?? null, 'images/logo.png') }}" alt="" width="38" height="38"><span>{{ $siteSettings['site_name'] ?? 'Aditech Multisolusi' }}</span></a>
        <div><span class="eyebrow">ADMIN CONSOLE</span><h1>Kelola website, leads, dan konten dari satu dashboard.</h1><p>CMS premium untuk menjaga website tetap aktif, relevan, dan siap mendukung pertumbuhan bisnis.</p></div>
    </section>
    <section class="login-form-panel">
        <button class="icon-button login-theme" type="button" data-theme-toggle aria-label="Ganti tema">◐</button>
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <h2>Masuk ke Admin</h2><p>Gunakan akun administrator Anda.</p>
            @if($errors->any())<div class="alert danger" role="alert">{{ $errors->first() }}</div>@endif
            <label>Email<input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus></label>
            <label>Password<input type="password" name="password" autocomplete="current-password" required></label>
            <label class="check"><input type="checkbox" name="remember"> Ingat saya</label>
            <button class="primary-button full" type="submit">Masuk</button>
            <a class="back-login" href="{{ route('home') }}">← Kembali ke website</a>
        </form>
    </section>
</div>
<script src="{{ asset('assets/js/admin.js') }}" defer></script>
<script>requestAnimationFrame(()=>document.documentElement.classList.remove('theme-preload'));</script>
</body>
</html>
