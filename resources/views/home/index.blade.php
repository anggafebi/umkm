@extends('layouts.app')
@section('title', $siteSettings['meta_title'] ?? 'Aditech Multisolusi | Solusi Digital UMKM')
@section('description', $siteSettings['meta_description'] ?? 'Website, katalog digital, dan sistem bisnis untuk UMKM.')
@section('body_class', 'home-page')

@php
    $serviceIcons = ['monitor', 'shopping-bag', 'database', 'bar-chart', 'layout-dashboard', 'wrench'];
    $fallbackServices = [
        ['name' => 'Website Company Profile', 'description' => 'Website profesional untuk membangun kredibilitas dan menjelaskan bisnis dengan lebih jelas.'],
        ['name' => 'Toko & Katalog Online', 'description' => 'Katalog produk yang rapi dengan pencarian, detail produk, dan alur pemesanan yang mudah.'],
        ['name' => 'Sistem Informasi', 'description' => 'Sistem internal untuk mengelola data, proses kerja, dan laporan bisnis dalam satu tempat.'],
        ['name' => 'Landing Page', 'description' => 'Halaman kampanye yang fokus pada satu penawaran dan mendorong calon pelanggan mengambil tindakan.'],
        ['name' => 'POS & Operasional', 'description' => 'Alur kasir, transaksi, stok, serta ringkasan operasional yang lebih terstruktur.'],
        ['name' => 'Maintenance', 'description' => 'Pemeliharaan, pembaruan, dan pengembangan lanjutan agar sistem tetap stabil dan relevan.'],
    ];
    
$demoProducts = [
    [
        'slug' => 'kopi-umkm',
        'product_slug' => 'website-toko-online-umkm',
        'title' => 'Website Toko Online UMKM',
        'type' => 'Website penjualan',
        'image' => 'images/products/kopi-umkm.png',
    ],
    [
        'slug' => 'goalgear-jersey',
        'product_slug' => 'website-ecommerce-jersey',
        'title' => 'Website E-Commerce Jersey',
        'type' => 'Website e-commerce',
        'image' => 'images/products/goal-gear.png',
    ],
    [
        'slug' => 'pos-kasir',
        'product_slug' => 'pos-kasir-digital',
        'title' => 'POS Kasir Digital',
        'type' => 'Sistem operasional',
        'image' => 'images/showcase/demo-pos-kasir.webp',
    ],
];

    $fallbackFaqs = [
        ['question' => 'Apakah solusi dapat disesuaikan dengan proses bisnis kami?', 'answer' => 'Ya. Ruang lingkup, fitur, dan tahapan pengerjaan disusun berdasarkan kebutuhan, prioritas, serta kesiapan bisnis Anda.'],
        ['question' => 'Apakah proyek dapat dikerjakan secara bertahap?', 'answer' => 'Bisa. Implementasi dapat dimulai dari kebutuhan yang paling penting, kemudian dikembangkan ketika proses dan anggaran sudah siap.'],
        ['question' => 'Apakah konten website dapat dikelola sendiri?', 'answer' => 'Bisa. Konten utama dapat dikelola melalui panel admin sehingga pembaruan tidak selalu memerlukan perubahan kode.'],
        ['question' => 'Berapa lama proses pengerjaannya?', 'answer' => 'Durasi bergantung pada ruang lingkup, kesiapan materi, dan jumlah integrasi. Estimasi diberikan setelah kebutuhan utama dipetakan.'],
    ];
@endphp

@section('content')
<section class="hero-premium">
    <div class="container hero-grid">
        <div class="hero-copy reveal">
            <h1>{{ $siteSettings['hero_title'] ?? 'Website dan sistem digital yang membuat bisnis lebih siap tumbuh.' }}</h1>
            <p>{{ $siteSettings['hero_subtitle'] ?? 'Kami membantu UMKM membangun website, katalog, dan sistem operasional yang jelas, cepat, dan mudah dikelola.' }}</p>

            <div class="hero-actions">
                <a class="button-primary" href="{{ route('consultation') }}">Mulai Konsultasi <x-icon name="arrow-right" size="18" /></a>
                <a class="button-secondary" href="{{ route('products.index') }}">Coba Demo Produk <x-icon name="arrow-up-right" size="17" /></a>
            </div>

            <div class="hero-trust" aria-label="Keunggulan utama">
                <span><x-icon name="check" size="15" /> Tampilan responsif</span>
                <span><x-icon name="check" size="15" /> Mudah dikelola</span>
                <span><x-icon name="check" size="15" /> Siap dikembangkan</span>
            </div>
        </div>

        <div class="hero-visual reveal" aria-label="Pratinjau produk digital Aditech">
            <div class="hero-orbit hero-orbit-one" aria-hidden="true"></div>
            <div class="hero-orbit hero-orbit-two" aria-hidden="true"></div>

            <div class="showcase-window showcase-window-main">
                <div class="showcase-toolbar">
                    <span class="showcase-dots" aria-hidden="true"><i></i><i></i><i></i></span>
                    <strong>POS & Operasional</strong>
                    <span class="showcase-status">Demo aktif</span>
                </div>
                <img src="{{ asset('images/showcase/demo-pos-kasir.webp') }}" alt="Pratinjau sistem POS kasir" width="1280" height="889" fetchpriority="high" decoding="async">
            </div>

            <div class="showcase-window showcase-window-side">
                <div class="showcase-toolbar compact">
                    <strong>Toko Online</strong>
                    <x-icon name="arrow-up-right" size="15" />
                </div>
                <img src="{{ asset('images/showcase/demo-toko-online.webp') }}" alt="Pratinjau toko online UMKM" width="1280" height="889" fetchpriority="high" decoding="async">
            </div>

            <a class="hero-demo-note" href="{{ route('products.index') }}"
                <span><strong>5 demo interaktif</strong><small>Coba alur produk sebelum berdiskusi</small></span>
                <x-icon name="arrow-right" size="19" />
            </a>
        </div>
    </div>
</section>

<section class="trust-strip" aria-label="Ringkasan solusi">
    <div class="container trust-grid">
        <div><strong>{{ $serviceCount }}</strong><span>Layanan digital</span></div>
        <div><strong>{{ $productCount }}</strong><span>Produk siap dicoba</span></div>
        <div><strong>1 panel</strong><span>Konten mudah dikelola</span></div>
        <div><strong>Mobile-first</strong><span>Nyaman di setiap perangkat</span></div>
    </div>
</section>

<section class="section services-home">
    <div class="container section-layout">
        <div class="section-heading left reveal">
            <span class="section-kicker">Layanan</span>
            <h2>{{ $siteSettings['services_title'] ?? 'Dari kehadiran online hingga sistem operasional.' }}</h2>
            <p>Setiap solusi dimulai dari masalah bisnis yang ingin diselesaikan, bukan dari teknologi yang ingin dipaksakan.</p>
            <a class="text-link" href="{{ route('services.index') }}">Lihat semua layanan <x-icon name="arrow-right" size="17" /></a>
        </div>

        <div class="service-grid-modern">
            @forelse($services as $service)
                <article class="service-card-modern reveal">
                    <div class="service-icon-modern"><x-icon :name="$serviceIcons[($loop->iteration - 1) % count($serviceIcons)]" size="22" /></div>
                    <span class="service-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3>{{ $service->name }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($service->short_description ?: $service->description, 145) }}</p>
                    <a href="{{ route('services.show', $service->slug) }}" aria-label="Pelajari {{ $service->name }}"><x-icon name="arrow-up-right" size="18" /></a>
                </article>
            @empty
                @foreach($fallbackServices as $service)
                    <article class="service-card-modern reveal">
                        <div class="service-icon-modern"><x-icon :name="$serviceIcons[$loop->index]" size="22" /></div>
                        <span class="service-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3>{{ $service['name'] }}</h3>
                        <p>{{ $service['description'] }}</p>
                        <a href="{{ route('services.index') }}" aria-label="Pelajari {{ $service['name'] }}"><x-icon name="arrow-up-right" size="18" /></a>
                    </article>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<section class="section demo-showcase-section">
    <div class="container">
        <div class="section-heading split reveal">
            <div>
                <span class="section-kicker">Demo Produk</span>
                <h2>Lihat alurnya. Coba langsung. Nilai sebelum memutuskan.</h2>
            </div>
            <p>Setiap demo berjalan langsung di browser dan memperlihatkan pengalaman penggunaan yang dapat dikembangkan lebih lanjut.</p>
        </div>

        <div class="demo-showcase-grid">
            @foreach($demoProducts as $demo)
                <a class="demo-product-card reveal"
                            href="{{ $demo['product_slug'] === null
                            ? route('products.index')
                            : route('products.show', $demo['product_slug']) }}">
                    <div class="demo-card-image"><img src="{{ asset($demo['image']) }}" alt="Pratinjau {{ $demo['title'] }}" loading="lazy" decoding="async"></div>
                    <div class="demo-card-copy">
                        <span>{{ $demo['type'] }}</span>
                        <h3>{{ $demo['title'] }}</h3>
                        <div>Coba demo <x-icon name="arrow-up-right" size="17" /></div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="demo-showcase-footer reveal">
            <p>Masih tersedia demo toko sepatu dan toko gadget untuk melihat variasi tampilan serta alur belanja.</p>
            <a class="button-light" href="{{ route('products.index') }}">Buka pusat demo <x-icon name="arrow-right" size="18" /></a>
        </div>
    </div>
</section>

<section class="section why-section">
    <div class="container why-layout">
        <div class="why-visual reveal">
            <div class="why-window">
                <div class="why-window-head"><span>aditech / workflow</span><span>01—04</span></div>
                <div class="why-window-body">
                    <div class="why-line why-line-lg"></div>
                    <div class="why-line"></div>
                    <div class="why-line why-line-sm"></div>
                    <div class="why-chart" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></div>
                </div>
            </div>
            <div class="why-badge"><strong>Rapi</strong><span>Dari desain sampai pengelolaan</span></div>
        </div>

        <div class="why-copy reveal">
            <span class="section-kicker">Kenapa Aditech</span>
            <h2>{{ $siteSettings['why_title'] ?? 'Solusi digital yang dibangun untuk kebutuhan bisnis nyata.' }}</h2>
            <p>{{ $siteSettings['why_description'] ?? 'Bukan sekadar tampilan. Setiap solusi dirancang agar mudah digunakan, mudah dikelola, dan tetap siap dikembangkan.' }}</p>

            <div class="why-list">
                @foreach([
                    ['title' => 'Arah visual yang konsisten', 'text' => 'Tipografi, warna, dan komponen dirancang sebagai satu sistem agar bisnis terlihat lebih kredibel.'],
                    ['title' => 'Fokus pada pengalaman pengguna', 'text' => 'Informasi, tombol, dan alur dibuat jelas sehingga pengguna tidak perlu menebak langkah berikutnya.'],
                    ['title' => 'Konten dapat dikelola', 'text' => 'Panel admin membantu tim memperbarui layanan, produk, portofolio, dan konten tanpa mengedit kode.'],
                    ['title' => 'Bisa berkembang bertahap', 'text' => 'Struktur dibangun agar fitur baru dapat ditambahkan sesuai prioritas dan pertumbuhan bisnis.'],
                ] as $item)
                    <article><span><x-icon name="check" size="16" /></span><div><h3>{{ $item['title'] }}</h3><p>{{ $item['text'] }}</p></div></article>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="section process-section">
    <div class="container">
        <div class="section-heading reveal">
            <span class="section-kicker">Proses Kerja</span>
            <h2>{{ $siteSettings['process_title'] ?? 'Terarah dari konsultasi hingga peluncuran.' }}</h2>
            <p>{{ $siteSettings['process_description'] ?? 'Setiap tahap memiliki hasil yang jelas agar proses tetap efisien dan keputusan lebih mudah diambil.' }}</p>
        </div>

        <div class="process-grid">
            @foreach([
                ['01', 'Pemetaan', 'Memahami tujuan, pengguna, masalah, dan prioritas bisnis.'],
                ['02', 'Struktur & Desain', 'Menyusun arsitektur informasi, alur pengguna, dan sistem visual.'],
                ['03', 'Pengembangan', 'Membangun, menguji, dan mengoptimalkan fungsi pada berbagai perangkat.'],
                ['04', 'Peluncuran', 'Menyiapkan publikasi, serah terima, dan dukungan setelah go-live.'],
            ] as $step)
                <article class="process-card reveal">
                    <span>{{ $step[0] }}</span>
                    <h3>{{ $step[1] }}</h3>
                    <p>{{ $step[2] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

@if($portfolios->isNotEmpty())
<section class="section portfolio-home">
    <div class="container">
        <div class="section-heading split reveal">
            <div>
                <span class="section-kicker">Portofolio</span>
                <h2>{{ $siteSettings['portfolio_title'] ?? 'Proyek yang dirancang untuk menghasilkan dampak.' }}</h2>
            </div>
            <a class="text-link" href="{{ route('portfolio.index') }}">Semua proyek <x-icon name="arrow-right" size="17" /></a>
        </div>

        <div class="portfolio-showcase">
            @foreach($portfolios as $item)
                <article class="portfolio-premium-card reveal">
                    <div class="portfolio-media">
                        @if($item->image)
                            <img class="media-safe" src="{{ \App\Support\Media::url($item->image, 'images/placeholder.svg') }}" alt="{{ $item->title }}" loading="lazy" decoding="async">
                        @else
                            <div class="portfolio-placeholder">
                                <span>{{ strtoupper($item->category ?: 'Digital Solution') }}</span>
                                <strong>{{ $item->title }}</strong>
                                <i aria-hidden="true"></i>
                            </div>
                        @endif
                    </div>
                    <div class="portfolio-meta">
                        <span>{{ $item->category ?: 'Solusi Digital' }}</span>
                        <h3>{{ $item->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($item->description, 125) }}</p>
                        <div class="tech-chips">
                            @foreach(array_filter(preg_split('/[,\n]+/', $item->technology ?? 'Laravel, Responsive, SEO')) as $tech)<i>{{ trim($tech) }}</i>@endforeach
                        </div>
                        <a href="{{ route('portfolio.show', $item->slug) }}">Lihat studi kasus <x-icon name="arrow-right" size="16" /></a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($pricingPackages->isNotEmpty())
<section class="section pricing-section">
    <div class="container">
        <div class="section-heading reveal">
            <span class="section-kicker">Paket</span>
            <h2>{{ $siteSettings['pricing_title'] ?? 'Pilih titik awal yang sesuai dengan kebutuhan bisnis.' }}</h2>
        </div>
        <div class="pricing-grid-modern">
            @foreach($pricingPackages as $item)
                <article class="pricing-card-modern {{ $item->highlight ? 'featured' : '' }} reveal">
                    @if($item->highlight)<span class="popular">Paling Populer</span>@endif
                    <h3>{{ $item->name }}</h3>
                    <strong>{{ $item->price }}</strong>
                    <ul>@foreach(array_filter(preg_split('/\r\n|\r|\n/', $item->features ?? '')) as $feature)<li>{{ $feature }}</li>@endforeach</ul>
                    <a href="{{ route('consultation') }}">Diskusikan Paket</a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($testimonials->isNotEmpty())
<section class="section testimonial-section">
    <div class="container">
        <div class="section-heading light reveal">
            <span class="section-kicker">Testimoni</span>
            <h2>{{ $siteSettings['testimonial_title'] ?? 'Pengalaman klien setelah proses digitalisasi.' }}</h2>
        </div>
        <div class="testimonial-slider" data-slider aria-label="Testimoni klien">
            @foreach($testimonials as $item)
                <article class="testimonial-card">
                    <div class="stars" aria-label="Rating {{ $item->rating }} dari 5">{{ str_repeat('★', $item->rating) }}</div>
                    <blockquote>“{{ $item->message }}”</blockquote>
                    <div class="client-row">
                        @if($item->photo)<img class="media-safe" src="{{ \App\Support\Media::url($item->photo, 'images/placeholder.svg') }}" alt="Foto {{ $item->name }}" loading="lazy" decoding="async">@else<span aria-hidden="true">{{ strtoupper(substr($item->name, 0, 1)) }}</span>@endif
                        <div><strong>{{ $item->name }}</strong><small>{{ $item->company }}</small></div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($posts->isNotEmpty())
<section class="section blog-home">
    <div class="container">
        <div class="section-heading split reveal">
            <div><span class="section-kicker">Artikel</span><h2>{{ $siteSettings['blog_title'] ?? 'Insight untuk keputusan digital yang lebih baik.' }}</h2></div>
            <a class="text-link" href="{{ route('blog.index') }}">Semua artikel <x-icon name="arrow-right" size="17" /></a>
        </div>
        <div class="blog-grid">
            @foreach($posts as $post)
                <article class="blog-card reveal">
                    <div class="blog-image">@if($post->image)<img class="media-safe" src="{{ \App\Support\Media::url($post->image, 'images/placeholder.svg') }}" alt="{{ $post->title }}" loading="lazy" decoding="async">@else<span>Insight</span>@endif</div>
                    <div><small>{{ $post->category?->name ?? 'Bisnis Digital' }} · {{ $post->published_at?->format('d M Y') }}</small><h3>{{ $post->title }}</h3><p>{{ $post->excerpt }}</p><a href="{{ route('blog.show', $post->slug) }}">Baca artikel <x-icon name="arrow-right" size="16" /></a></div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section faq-section">
    <div class="container faq-layout">
        <div class="section-heading left reveal">
            <span class="section-kicker">FAQ</span>
            <h2>{{ $siteSettings['faq_title'] ?? 'Pertanyaan sebelum memulai proyek.' }}</h2>
            <p>{{ $siteSettings['faq_description'] ?? 'Informasi dasar untuk membantu Anda memahami proses, ruang lingkup, dan cara kerja sama.' }}</p>
        </div>
        <div class="faq-list">
            @if($faqs->isNotEmpty())
                @foreach($faqs as $faq)
                    <details class="faq-item reveal"><summary>{{ $faq->question }}<span aria-hidden="true">+</span></summary><p>{{ $faq->answer }}</p></details>
                @endforeach
            @else
                @foreach($fallbackFaqs as $faq)
                    <details class="faq-item reveal"><summary>{{ $faq['question'] }}<span aria-hidden="true">+</span></summary><p>{{ $faq['answer'] }}</p></details>
                @endforeach
            @endif
        </div>
    </div>
</section>

<section class="cta-premium">
    <div class="container reveal">
        <div class="cta-mark"><img src="{{ asset('images/logo-mark.svg') }}" alt="" width="54" height="54"></div>
        <h2>{{ $siteSettings['cta_title'] ?? 'Bangun fondasi digital yang lebih profesional untuk bisnis Anda.' }}</h2>
        <p>{{ $siteSettings['cta_description'] ?? 'Ceritakan target dan kendala bisnis Anda. Kami bantu memetakan solusi yang relevan dan realistis.' }}</p>
        <div>
            <a class="button-light" href="{{ route('consultation') }}">Mulai Konsultasi <x-icon name="arrow-right" size="18" /></a>
            <a class="button-ghost-light" href="{{ route('contact') }}">Hubungi Kami</a>
        </div>
    </div>
</section>
@endsection
