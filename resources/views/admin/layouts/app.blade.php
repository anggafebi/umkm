<!DOCTYPE html>
<html lang="id" class="theme-preload">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Admin') | {{ $siteSettings['site_name'] ?? 'Aditech Multisolusi' }}</title>
    <script>(()=>{const s=localStorage.getItem('aditech-theme');const system=matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';const t=['light','dark'].includes(s)?s:system;document.documentElement.dataset.theme=t;document.documentElement.style.colorScheme=t;})();</script>
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">

<link rel="stylesheet" href="{{ asset('assets/css/refactor-modern.css') }}">
</head>
<body class="admin-body">
<div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Navigasi admin">
        <a class="admin-brand" href="{{ route('admin.dashboard') }}"><img src="{{ \App\Support\Media::url($siteSettings['logo_path'] ?? null, 'images/logo.png') }}" alt="" width="38" height="38"><span>{{ $siteSettings['site_name'] ?? 'Aditech' }}</span></a>
        <div class="admin-nav-label">OVERVIEW</div>
        <nav class="admin-nav">
            <a class="{{ request()->routeIs('admin.dashboard')?'active':'' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a class="{{ request()->routeIs('admin.consultations.*')?'active':'' }}" href="{{ route('admin.consultations.index') }}">Leads & Konsultasi</a>
            <a class="{{ request()->routeIs('admin.newsletter.*')?'active':'' }}" href="{{ route('admin.newsletter.index') }}">Newsletter</a>
            <div class="admin-nav-label">KONTEN</div>
            <a class="{{ request()->routeIs('admin.services.*')?'active':'' }}" href="{{ route('admin.services.index') }}">Layanan</a>
            <a class="{{ request()->routeIs('admin.products.*')?'active':'' }}" href="{{ route('admin.products.index') }}">Produk</a>
            <a class="{{ request()->routeIs('admin.portfolio.*')?'active':'' }}" href="{{ route('admin.portfolio.index') }}">Portfolio</a>
            <a class="{{ request()->routeIs('admin.blog.*')?'active':'' }}" href="{{ route('admin.blog.index') }}">Blog</a>
            <a class="{{ request()->routeIs('admin.testimonials.*')?'active':'' }}" href="{{ route('admin.testimonials.index') }}">Testimoni</a>
            <a class="{{ request()->routeIs('admin.faqs.*')?'active':'' }}" href="{{ route('admin.faqs.index') }}">FAQ</a>
            <a class="{{ request()->routeIs('admin.pricing.*')?'active':'' }}" href="{{ route('admin.pricing.index') }}">Paket Harga</a>
            <div class="admin-nav-label">SISTEM</div>
            <a class="{{ request()->routeIs('admin.media.*')?'active':'' }}" href="{{ route('admin.media.index') }}">Media Manager</a>
            @if(auth()->user()->role === 'admin')<a class="{{ request()->routeIs('admin.settings.*')?'active':'' }}" href="{{ route('admin.settings.index') }}">Website & SEO</a>@endif
            <a class="{{ request()->routeIs('admin.profile.*')?'active':'' }}" href="{{ route('admin.profile.index') }}">Profil Saya</a>
            @if(auth()->user()->role === 'admin')<a class="{{ request()->routeIs('admin.users.*')?'active':'' }}" href="{{ route('admin.users.index') }}">Pengguna Admin</a>@endif
            <a href="{{ route('home') }}" target="_blank" rel="noopener">Lihat Website ↗</a>
        </nav>
    </aside>
    <div class="admin-sidebar-backdrop" data-admin-backdrop></div>
    <main class="admin-main">
        <header class="admin-topbar">
            <button class="icon-button menu-button" type="button" data-admin-menu aria-controls="adminSidebar" aria-expanded="false" aria-label="Buka menu admin">☰</button>
            <div><strong>@yield('page_title','Dashboard')</strong><span class="topbar-subtitle">Kelola platform digital bisnis Anda</span></div>
            <div class="admin-top-actions">
                <button class="icon-button" type="button" data-theme-toggle title="Ganti tema" aria-label="Ganti tema">◐</button>
                <div class="admin-user"><span>{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span><div><strong>{{ auth()->user()->name }}</strong><small>{{ ucfirst(auth()->user()->role) }}</small></div></div>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="ghost-button" type="submit">Keluar</button></form>
            </div>
        </header>
        <section class="admin-content">
            @if(session('success'))<div class="alert success" role="status">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="alert danger" role="alert"><strong>Periksa input:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @yield('content')
        </section>
    </main>
</div>
<script src="{{ asset('assets/js/admin.js') }}" defer></script>
<script>requestAnimationFrame(()=>document.documentElement.classList.remove('theme-preload'));</script>
@stack('scripts')
</body>
</html>
