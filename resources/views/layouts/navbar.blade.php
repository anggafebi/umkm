<header class="site-header" data-header>
    <div class="container navbar-modern">
        <a href="{{ route('home') }}" class="brand" aria-label="{{ $siteSettings['site_name'] ?? 'Aditech Multisolusi' }} - Beranda">
            <img src="{{ asset('images/logo-mark.svg') }}" alt="" class="logo" width="44" height="44">
            <span class="brand-copy">
                <strong>Aditech</strong>
                <small>Multisolusi</small>
            </span>
        </a>

        <nav class="nav-links" id="primaryNavigation" data-nav aria-label="Navigasi utama">
            <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
            <a class="{{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">Layanan</a>
            <a class="{{ request()->routeIs('products.*') || request()->routeIs('demo.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Produk</a>
            <a class="{{ request()->routeIs('portfolio.*') ? 'active' : '' }}" href="{{ route('portfolio.index') }}">Portofolio</a>
            <a class="{{ request()->routeIs('blog.*') ? 'active' : '' }}" href="{{ route('blog.index') }}">Artikel</a>
            <a class="{{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang</a>
            <a class="nav-cta nav-cta-mobile" href="{{ route('consultation') }}">Mulai Konsultasi <x-icon name="arrow-right" size="17" /></a>
        </nav>

        <div class="nav-actions">
            @if(($siteSettings['dark_mode_enabled'] ?? '1') === '1')
                <button type="button" class="theme-toggle" data-theme-toggle aria-label="Ganti tema terang atau gelap" title="Ganti tema">
                    <span class="sun" aria-hidden="true"><x-icon name="sun" size="19" /></span>
                    <span class="moon" aria-hidden="true"><x-icon name="moon" size="19" /></span>
                </button>
            @endif
            <a class="header-cta" href="{{ route('consultation') }}">Konsultasi <x-icon name="arrow-right" size="17" /></a>
            <button type="button" class="mobile-menu-btn" data-mobile-menu aria-controls="primaryNavigation" aria-expanded="false" aria-label="Buka menu navigasi">
                <span class="menu-open-icon" aria-hidden="true"><x-icon name="menu" size="21" /></span>
                <span class="menu-close-icon" aria-hidden="true"><x-icon name="x" size="21" /></span>
            </button>
        </div>
    </div>
</header>
