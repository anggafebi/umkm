@php($waFooter = preg_replace('/\D+/', '', $siteSettings['phone'] ?? '6287848127894'))
<footer class="footer-premium">
    <div class="container footer-intro">
        <div>
            <span class="footer-overline">Punya kebutuhan digital?</span>
            <h2>Bangun sistem yang rapi sejak awal.</h2>
        </div>
        <a class="footer-cta" href="{{ route('consultation') }}">Diskusikan kebutuhan <x-icon name="arrow-right" size="18" /></a>
    </div>

    <div class="container footer-grid">
        <div class="footer-brand">
            <a href="{{ route('home') }}" class="brand">
                <img src="{{ asset('images/logo-mark.svg') }}" class="logo" alt="" width="44" height="44">
                <span class="brand-copy"><strong>Aditech</strong><small>Multisolusi</small></span>
            </a>
            <p>{{ $siteSettings['tagline'] ?? 'Website dan sistem bisnis yang membantu UMKM bekerja lebih profesional.' }}</p>
            <a class="footer-whatsapp" href="https://wa.me/{{ str_starts_with($waFooter, '0') ? '62'.substr($waFooter, 1) : $waFooter }}?text=Halo%20Aditech,%20saya%20ingin%20berdiskusi" target="_blank" rel="noopener">
                <x-icon name="message-square" size="17" /> WhatsApp
            </a>
        </div>

        <div class="footer-column">
            <h3>Solusi</h3>
            <a href="{{ route('services.index') }}">Layanan Digital</a>
            <a href="{{ route('products.index') }}">Produk & Demo</a>
            <a href="{{ route('portfolio.index') }}">Portofolio</a>
        </div>

        <div class="footer-column">
            <h3>Perusahaan</h3>
            <a href="{{ route('about') }}">Tentang Kami</a>
            <a href="{{ route('blog.index') }}">Artikel</a>
            <a href="{{ route('contact') }}">Kontak</a>
            <a href="{{ route('consultation') }}">Konsultasi</a>
        </div>

        <div class="footer-column footer-contact">
            <h3>Kontak</h3>
            <a href="tel:{{ preg_replace('/\D+/', '', $siteSettings['phone'] ?? '087848127894') }}"><x-icon name="phone" size="16" /> {{ $siteSettings['phone'] ?? '087848127894' }}</a>
            <a href="mailto:{{ $siteSettings['email'] ?? 'info@aditech.id' }}"><x-icon name="mail" size="16" /> {{ $siteSettings['email'] ?? 'info@aditech.id' }}</a>
            <span><x-icon name="map-pin" size="16" /> {{ $siteSettings['location'] ?? 'Indonesia' }}</span>
        </div>

        <div class="newsletter-box">
            <strong>Dapatkan insight bisnis digital</strong>
            <p>Artikel singkat dan praktis, dikirim saat ada pembaruan penting.</p>
            <form method="POST" action="{{ route('newsletter.store') }}">
                @csrf
                <label class="sr-only" for="newsletterEmail">Email newsletter</label>
                <input id="newsletterEmail" type="email" name="email" placeholder="email@bisnis.com" autocomplete="email" required>
                <button type="submit" aria-label="Daftar newsletter"><x-icon name="arrow-right" size="18" /></button>
            </form>
            @if(session('newsletter_success'))<small role="status">{{ session('newsletter_success') }}</small>@endif
        </div>
    </div>

    <div class="container footer-bottom">
        <span>© {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'Aditech Multisolusi' }}.</span>
        <span>Website dan sistem bisnis untuk UMKM.</span>
    </div>
</footer>
