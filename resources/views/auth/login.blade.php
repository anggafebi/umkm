<!DOCTYPE html>
<html lang="id" class="theme-preload">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/logo-mark.svg') }}" type="image/svg+xml">
    <meta name="robots" content="noindex,nofollow">
    <title>Login Admin | {{ $siteSettings['site_name'] ?? 'Aditech' }}</title>
    <script>(()=>{let s=null;try{s=localStorage.getItem('aditech-theme')}catch(_){}const t=['light','dark'].includes(s)?s:(matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light');document.documentElement.dataset.theme=t;document.documentElement.style.colorScheme=t})();</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <style>:root{--a-primary:{{ $siteSettings['primary_color'] ?? '#315ff4' }};}</style>
</head>
<body class="login-page">
<div class="login-shell">
    <section class="login-brand-panel" aria-label="Tentang admin console">
        <div class="login-brand-top">
            <a href="{{ route('home') }}" class="admin-brand">
                <img src="{{ asset('images/logo-mark.svg') }}" alt="" width="42" height="42">
                <span><strong>Aditech</strong><small>Multisolusi</small></span>
            </a>
        </div>
        <div class="login-brand-copy">
            <h1>Satu ruang kerja untuk mengelola bisnis digital.</h1>
            <p>Perbarui konten, pantau leads, atur produk, dan jaga website tetap relevan dari satu dashboard yang terstruktur.</p>
            <div class="login-benefits">
                <span><x-icon name="check" size="16" /> Konten website terpusat</span>
                <span><x-icon name="check" size="16" /> Data prospek lebih mudah dipantau</span>
                <span><x-icon name="check" size="16" /> Tampilan responsif dan aman</span>
            </div>
        </div>
        <small class="login-copyright">Aditech CMS · {{ date('Y') }}</small>
    </section>

    <section class="login-form-panel">
        <button class="icon-button login-theme theme-button" type="button" data-theme-toggle aria-label="Ganti tema">
            <span class="sun"><x-icon name="sun" size="18" /></span>
            <span class="moon"><x-icon name="moon" size="18" /></span>
        </button>
        <div class="login-form-wrap">
            <div class="login-mobile-brand">
                <img src="{{ asset('images/logo-mark.svg') }}" alt="" width="42" height="42">
                <span><strong>Aditech</strong><small>Admin workspace</small></span>
            </div>
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="login-heading"><h2>Masuk ke dashboard</h2><p>Gunakan akun administrator yang terdaftar.</p></div>
                @if($errors->any())<div class="alert danger" role="alert"><span>{{ $errors->first() }}</span></div>@endif
                <label>Email<input type="email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="nama@email.com" required autofocus></label>
                <label>Password<input type="password" name="password" autocomplete="current-password" placeholder="Masukkan password" required></label>
                <label class="check"><input type="checkbox" name="remember"><span>Ingat saya di perangkat ini</span></label>
                <button class="primary-button full" type="submit">Masuk ke Dashboard <x-icon name="arrow-right" size="17" /></button>
                <a class="back-login" href="{{ route('home') }}"><x-icon name="arrow-left" size="16" /> Kembali ke website</a>
            </form>
        </div>
    </section>
</div>
<script src="{{ asset('assets/js/admin.js') }}" defer></script>
<script>requestAnimationFrame(()=>document.documentElement.classList.remove('theme-preload'));</script>
</body>
</html>
