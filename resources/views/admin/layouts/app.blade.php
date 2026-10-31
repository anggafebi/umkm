<!DOCTYPE html>
<html lang="id" class="theme-preload">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/logo-mark.svg') }}" type="image/svg+xml">
    <meta name="robots" content="noindex,nofollow">
    <title>@yield('title','Admin') | {{ $siteSettings['site_name'] ?? 'Aditech Multisolusi' }}</title>
    <script>(()=>{let s=null;try{s=localStorage.getItem('aditech-theme')}catch(_){}const system=window.matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';const t=['light','dark'].includes(s)?s:system;document.documentElement.dataset.theme=t;document.documentElement.style.colorScheme=t;})();</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <style>:root{--a-primary:{{ $siteSettings['primary_color'] ?? '#315ff4' }};}</style>
</head>
<body class="admin-body">
<div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Navigasi admin">
        <div class="admin-sidebar-head">
            <a class="admin-brand" href="{{ route('home') }}" aria-label="Ke beranda website Aditech" title="Lihat beranda website">
                <img src="{{ asset('images/logo-mark.svg') }}" alt="" width="42" height="42">
                <span><strong>Aditech</strong><small>Admin workspace</small></span>
            </a>
            <button class="admin-sidebar-close" type="button" data-admin-menu aria-label="Tutup menu"><x-icon name="x" size="19" /></button>
        </div>

        <nav class="admin-nav">
            <div class="admin-nav-group">
                <p class="admin-nav-label">Ringkasan</p>
                <a class="{{ request()->routeIs('admin.dashboard')?'active':'' }}" href="{{ route('admin.dashboard') }}"><x-icon name="layout-dashboard" size="18" /><span>Dashboard</span></a>
                <a class="{{ request()->routeIs('admin.consultations.*')?'active':'' }}" href="{{ route('admin.consultations.index') }}"><x-icon name="message-square" size="18" /><span>Leads & Konsultasi</span>@php($unreadLeads = \App\Models\SystemNotification::where('user_id', auth()->id())->whereIn('type', ['consultation_new', 'consultation_client_reply'])->whereNull('read_at')->count())@if($unreadLeads)<span class="status new" aria-label="{{ $unreadLeads }} konsultasi baru">{{ $unreadLeads }}</span>@endif</a>
                <a class="{{ request()->routeIs('admin.newsletter.*')?'active':'' }}" href="{{ route('admin.newsletter.index') }}"><x-icon name="mail" size="18" /><span>Newsletter</span></a>
            </div>

            <div class="admin-nav-group">
                <p class="admin-nav-label">Konten website</p>
                <a class="{{ request()->routeIs('admin.services.*')?'active':'' }}" href="{{ route('admin.services.index') }}"><x-icon name="wrench" size="18" /><span>Layanan</span></a>
                <a class="{{ request()->routeIs('admin.products.*')?'active':'' }}" href="{{ route('admin.products.index') }}"><x-icon name="package" size="18" /><span>Produk</span></a>
                <a class="{{ request()->routeIs('admin.portfolio.*')?'active':'' }}" href="{{ route('admin.portfolio.index') }}"><x-icon name="briefcase" size="18" /><span>Portofolio</span></a>
                <a class="{{ request()->routeIs('admin.blog.*')?'active':'' }}" href="{{ route('admin.blog.index') }}"><x-icon name="file-text" size="18" /><span>Artikel</span></a>
                <a class="{{ request()->routeIs('admin.testimonials.*')?'active':'' }}" href="{{ route('admin.testimonials.index') }}"><x-icon name="star" size="18" /><span>Testimoni</span></a>
                <a class="{{ request()->routeIs('admin.faqs.*')?'active':'' }}" href="{{ route('admin.faqs.index') }}"><x-icon name="circle-help" size="18" /><span>FAQ</span></a>
                <a class="{{ request()->routeIs('admin.pricing.*')?'active':'' }}" href="{{ route('admin.pricing.index') }}"><x-icon name="credit-card" size="18" /><span>Paket Harga</span></a>
            </div>

            <div class="admin-nav-group">
                <p class="admin-nav-label">Sistem</p>
                <a class="{{ request()->routeIs('admin.media.*')?'active':'' }}" href="{{ route('admin.media.index') }}"><x-icon name="image" size="18" /><span>Media</span></a>
                @if(auth()->user()->role === 'admin')
                    <a class="{{ request()->routeIs('admin.settings.*')?'active':'' }}" href="{{ route('admin.settings.index') }}"><x-icon name="settings" size="18" /><span>Website & SEO</span></a>
                @endif
                <a class="{{ request()->routeIs('admin.profile.*')?'active':'' }}" href="{{ route('admin.profile.index') }}"><x-icon name="user" size="18" /><span>Profil Saya</span></a>
                @if(auth()->user()->role === 'admin')
                    <a class="{{ request()->routeIs('admin.users.*')?'active':'' }}" href="{{ route('admin.users.index') }}"><x-icon name="users" size="18" /><span>Pengguna Admin</span></a>
                @endif
            </div>
        </nav>

        <div class="admin-sidebar-foot">
            <a href="{{ route('home') }}" target="_blank" rel="noopener"><x-icon name="external-link" size="17" /><span>Lihat website</span></a>
            <p>Aditech CMS · {{ date('Y') }}</p>
        </div>
    </aside>

    <div class="admin-sidebar-backdrop" data-admin-backdrop></div>

    <main class="admin-main">
        <header class="admin-topbar">
            <div class="admin-topbar-left">
                <button class="icon-button menu-button" type="button" data-admin-menu aria-controls="adminSidebar" aria-expanded="false" aria-label="Buka menu admin"><x-icon name="menu" size="20" /></button>
                <div class="admin-page-heading"><strong>@yield('page_title','Dashboard')</strong><span class="topbar-subtitle">Kelola website dan operasional digital</span></div>
            </div>
            <div class="admin-top-actions">
                <button class="icon-button theme-button" type="button" data-theme-toggle title="Ganti tema" aria-label="Ganti tema">
                    <span class="sun"><x-icon name="sun" size="18" /></span>
                    <span class="moon"><x-icon name="moon" size="18" /></span>
                </button>
                <div class="admin-user">
                    <span class="admin-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span>
                    <div><strong>{{ auth()->user()->name }}</strong><small>{{ ucfirst(auth()->user()->role) }}</small></div>
                </div>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="logout-button" type="submit" aria-label="Keluar"><x-icon name="log-out" size="18" /><span>Keluar</span></button></form>
            </div>
        </header>

        <section class="admin-content">
            @if(session('success'))<div class="alert success" role="status"><x-icon name="check" size="18" /><span>{{ session('success') }}</span></div>@endif
            @if($errors->any())<div class="alert danger" role="alert"><div><strong>Periksa input berikut:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>@endif
            @yield('content')
        </section>
    </main>
</div>
<script src="{{ asset('assets/js/admin.js') }}" defer></script>
<script>requestAnimationFrame(()=>document.documentElement.classList.remove('theme-preload'));</script>
@stack('scripts')
</body>
</html>
