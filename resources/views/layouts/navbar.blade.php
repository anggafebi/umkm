<header class="site-header" data-header>
    <div class="container navbar-modern">
        <a href="{{ route('home') }}" class="brand" aria-label="{{ $siteSettings['site_name'] ?? 'Aditech Multisolusi' }} - Beranda">
            <img src="{{ \App\Support\Media::url($siteSettings['logo_path'] ?? null, 'images/logo.png') }}" alt="" class="logo" width="38" height="38">
            <span>{{ $siteSettings['site_name'] ?? 'Aditech Multisolusi' }}</span>
        </a>
        <nav class="nav-links" id="primaryNavigation" data-nav aria-label="Navigasi utama">
            <a class="{{ request()->routeIs('home')?'active':'' }}" href="{{ route('home') }}">Home</a>
            <a class="{{ request()->routeIs('services.*')?'active':'' }}" href="{{ route('services.index') }}">Layanan</a>
            <a class="{{ request()->routeIs('portfolio.*')?'active':'' }}" href="{{ route('portfolio.index') }}">Portfolio</a>
            <a class="{{ request()->routeIs('products.*')?'active':'' }}" href="{{ route('products.index') }}">Produk</a>
            <a class="{{ request()->routeIs('blog.*')?'active':'' }}" href="{{ route('blog.index') }}">Insight</a>
            <a class="{{ request()->routeIs('about')?'active':'' }}" href="{{ route('about') }}">Tentang</a>
            <a class="nav-cta" href="{{ route('consultation') }}">Konsultasi</a>
        </nav>
        <div class="nav-actions">
            @if(($siteSettings['dark_mode_enabled'] ?? '1') === '1')<button type="button" class="theme-toggle" data-theme-toggle aria-label="Ganti tema terang atau gelap" title="Ganti tema"><span class="sun" aria-hidden="true">☀</span><span class="moon" aria-hidden="true">☾</span></button>@endif
            <button type="button" class="mobile-menu-btn" data-mobile-menu aria-controls="primaryNavigation" aria-expanded="false" aria-label="Buka menu navigasi"><span aria-hidden="true">☰</span></button>
        </div>
    </div>
</header>
