<?php

namespace App\Support;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;

class PublicContentFallbacks
{
    public static function services(): Collection
    {
        return self::items([
            [
                'id' => 1,
                'name' => 'Website Company Profile',
                'slug' => 'website-company-profile',
                'short_description' => 'Website profesional untuk meningkatkan kredibilitas bisnis.',
                'description' => 'Website company profile membantu bisnis memperkenalkan perusahaan, layanan, keunggulan, dan informasi penting kepada calon pelanggan secara profesional.',
                'target_user' => 'UMKM, perusahaan jasa, startup, organisasi, dan bisnis yang membutuhkan kehadiran digital profesional.',
                'problem' => 'Bisnis belum memiliki media resmi untuk membangun kepercayaan dan memberikan informasi kepada pelanggan.',
                'solution' => 'Kehadiran digital yang terstruktur, mudah dipahami, dan dapat dikelola secara mandiri.',
                'features' => 'Profil bisnis, halaman layanan, galeri, kontak WhatsApp, SEO dasar, desain responsif.',
            ],
            [
                'id' => 2,
                'name' => 'Website Toko Produk',
                'slug' => 'website-toko-produk',
                'short_description' => 'Website untuk menampilkan dan menjual produk secara online.',
                'description' => 'Website toko produk membantu bisnis memiliki katalog penjualan online dengan informasi produk yang mudah diakses pelanggan.',
                'target_user' => 'UMKM retail, produsen, distributor, dan bisnis yang menjual produk fisik.',
                'problem' => 'Penjualan masih bergantung pada media sosial tanpa katalog produk yang terstruktur.',
                'solution' => 'Katalog digital dengan alur pemesanan yang jelas dan dapat disesuaikan.',
                'features' => 'Katalog produk, detail produk, pencarian, pemesanan WhatsApp, integrasi pembayaran.',
            ],
            [
                'id' => 3,
                'name' => 'Landing Page',
                'slug' => 'landing-page',
                'short_description' => 'Halaman promosi untuk produk, jasa, atau kampanye.',
                'description' => 'Landing page dirancang untuk meningkatkan fokus pengunjung terhadap satu produk atau layanan tertentu.',
                'target_user' => 'Bisnis yang menjalankan promosi digital, iklan, atau kampanye.',
                'problem' => 'Promosi digital belum memiliki halaman khusus untuk meningkatkan konversi.',
                'solution' => 'Halaman fokus dengan pesan, bukti, dan ajakan tindakan yang terukur.',
                'features' => 'Hero section, CTA, formulir leads, testimoni, pelacakan dasar.',
            ],
            [
                'id' => 4,
                'name' => 'Website Katalog',
                'slug' => 'website-katalog',
                'short_description' => 'Katalog digital untuk menampilkan banyak produk.',
                'description' => 'Website katalog membantu bisnis menampilkan banyak produk tanpa harus langsung menggunakan sistem transaksi online.',
                'target_user' => 'Distributor, supplier, manufaktur, dan bisnis dengan banyak produk.',
                'problem' => 'Informasi produk masih tersebar dan sulit dikelola.',
                'solution' => 'Katalog terpusat dengan pencarian, kategori, dan detail produk.',
                'features' => 'Kategori produk, filter, detail produk, galeri, pertanyaan pelanggan.',
            ],
            [
                'id' => 5,
                'name' => 'Sistem Informasi UMKM',
                'slug' => 'sistem-informasi-umkm',
                'short_description' => 'Sistem digital untuk membantu pengelolaan bisnis.',
                'description' => 'Sistem informasi membantu bisnis mengelola data operasional secara lebih rapi dan terintegrasi.',
                'target_user' => 'UMKM berkembang yang membutuhkan sistem internal.',
                'problem' => 'Pengelolaan data masih manual menggunakan spreadsheet.',
                'solution' => 'Alur data terpusat dengan hak akses dan laporan yang mudah dibaca.',
                'features' => 'Manajemen data, laporan, dashboard, manajemen pengguna.',
            ],
            [
                'id' => 6,
                'name' => 'POS System',
                'slug' => 'pos-system',
                'short_description' => 'Sistem kasir dan operasional bisnis.',
                'description' => 'POS membantu bisnis mengelola transaksi penjualan dan laporan operasional.',
                'target_user' => 'Toko retail, restoran, kafe, dan usaha layanan.',
                'problem' => 'Pencatatan transaksi belum terintegrasi.',
                'solution' => 'Sistem transaksi yang cepat dengan riwayat dan laporan penjualan.',
                'features' => 'Kasir, transaksi, laporan penjualan, stok produk.',
            ],
            [
                'id' => 7,
                'name' => 'Custom Website',
                'slug' => 'custom-website',
                'short_description' => 'Pengembangan website sesuai kebutuhan khusus bisnis.',
                'description' => 'Website custom dibuat berdasarkan kebutuhan proses bisnis tertentu.',
                'target_user' => 'Perusahaan yang membutuhkan solusi khusus.',
                'problem' => 'Solusi website standar belum mampu memenuhi kebutuhan bisnis.',
                'solution' => 'Arsitektur dan alur kerja yang disusun berdasarkan kebutuhan operasional.',
                'features' => 'Alur kerja khusus, integrasi sistem, database, API.',
            ],
        ]);
    }

    public static function products(): Collection
    {
        return self::items([
            ['id' => 1, 'name' => 'Website Toko Online UMKM', 'slug' => 'website-toko-online-umkm', 'description' => 'Website penjualan online dengan katalog produk dan integrasi WhatsApp.', 'price' => 3500000, 'image' => 'images/showcase/demo-toko-online.webp'],
            ['id' => 2, 'name' => 'POS Kasir Digital', 'slug' => 'pos-kasir-digital', 'description' => 'Sistem kasir digital untuk transaksi dan laporan bisnis.', 'price' => 5000000, 'image' => 'images/showcase/demo-pos-kasir.webp'],
            ['id' => 3, 'name' => 'Website Katalog Produk', 'slug' => 'website-katalog-produk', 'description' => 'Katalog digital profesional untuk menampilkan produk.', 'price' => 2500000, 'image' => 'images/showcase/demo-katalog.webp'],
            ['id' => 4, 'name' => 'Demo Toko Sepatu Online', 'slug' => 'demo-toko-sepatu-online', 'description' => 'Demo website toko online sepatu dengan katalog produk digital.', 'price' => 3000000, 'image' => 'images/showcase/demo-sepatu.webp'],
            ['id' => 5, 'name' => 'Demo Toko iPhone Online', 'slug' => 'demo-toko-iphone-online', 'description' => 'Demo website penjualan iPhone dengan tampilan modern.', 'price' => 3000000, 'image' => 'images/showcase/demo-iphone.webp'],
        ]);
    }

    public static function portfolios(): Collection
    {
        return self::items([
            [
                'id' => 1,
                'title' => 'Website Company Profile UMKM',
                'slug' => 'website-company-profile-umkm',
                'category' => 'Website',
                'description' => 'Website profil bisnis profesional dengan informasi layanan, keunggulan, dan alur kontak yang jelas.',
                'features' => 'Profil bisnis, layanan, galeri, formulir kontak, integrasi WhatsApp',
                'technology' => 'Laravel, SQLite, Responsive CSS',
                'demo_url' => null,
                'image' => 'images/showcase/demo-toko-online.webp',
            ],
            [
                'id' => 2,
                'title' => 'Sistem Informasi Bisnis',
                'slug' => 'sistem-informasi-bisnis',
                'category' => 'Sistem',
                'description' => 'Sistem pengelolaan data bisnis untuk menyatukan proses operasional dan laporan dalam satu panel.',
                'features' => 'Dashboard, laporan, manajemen data, hak akses pengguna',
                'technology' => 'Laravel, SQLite, JavaScript',
                'demo_url' => null,
                'image' => 'images/showcase/demo-pos-kasir.webp',
            ],
        ]);
    }

    public static function posts(): Collection
    {
        $category = new Fluent(['name' => 'Bisnis Digital', 'slug' => 'bisnis-digital']);

        return self::items([
            [
                'id' => 1,
                'title' => 'Fondasi Website UMKM yang Mudah Dipahami Pelanggan',
                'slug' => 'fondasi-website-umkm',
                'excerpt' => 'Struktur informasi yang jelas membantu pengunjung memahami bisnis, layanan, dan langkah berikutnya tanpa kebingungan.',
                'content' => "Website bisnis tidak harus penuh fitur. Fondasi yang baik dimulai dari pesan utama yang jelas, navigasi yang sederhana, informasi layanan yang mudah dipindai, dan ajakan tindakan yang konsisten.\n\nPastikan setiap halaman memiliki satu tujuan utama. Gunakan bahasa yang langsung, tampilkan bukti yang relevan, dan prioritaskan pengalaman pada perangkat seluler.",
                'image' => null,
                'status' => 'published',
                'meta_title' => 'Fondasi Website UMKM yang Efektif',
                'meta_description' => 'Panduan menyusun fondasi website UMKM yang jelas, terarah, dan mudah digunakan.',
                'published_at' => Carbon::parse('2026-10-12'),
                'category' => $category,
                'blog_category_id' => 1,
            ],
            [
                'id' => 2,
                'title' => 'Kapan Bisnis Perlu Beralih dari Spreadsheet ke Sistem?',
                'slug' => 'kapan-bisnis-perlu-sistem',
                'excerpt' => 'Kenali tanda ketika data yang tersebar dan proses manual mulai menghambat operasional serta pengambilan keputusan.',
                'content' => "Spreadsheet tetap berguna pada tahap awal. Masalah muncul ketika banyak orang mengedit file berbeda, data sering ganda, laporan terlambat, dan riwayat perubahan sulit ditelusuri.\n\nSistem khusus mulai relevan ketika proses inti sudah berulang dan dapat didefinisikan. Mulailah dari satu alur paling penting, ukur dampaknya, lalu kembangkan secara bertahap.",
                'image' => null,
                'status' => 'published',
                'meta_title' => 'Tanda Bisnis Membutuhkan Sistem Operasional',
                'meta_description' => 'Tanda praktis bahwa proses bisnis perlu dipindahkan dari spreadsheet ke sistem yang lebih terstruktur.',
                'published_at' => Carbon::parse('2026-10-05'),
                'category' => $category,
                'blog_category_id' => 1,
            ],
            [
                'id' => 3,
                'title' => 'Cara Menentukan Prioritas Fitur untuk Produk Digital',
                'slug' => 'prioritas-fitur-produk-digital',
                'excerpt' => 'Prioritas yang baik berangkat dari masalah pengguna, dampak bisnis, dan biaya implementasi—bukan dari banyaknya ide.',
                'content' => "Daftar fitur yang panjang tidak selalu menghasilkan produk yang lebih baik. Tentukan pengguna utama, masalah yang paling sering terjadi, dan hasil yang ingin dicapai.\n\nKelompokkan fitur menjadi kebutuhan inti, pendukung, dan pengembangan lanjutan. Bangun versi awal yang menyelesaikan alur utama secara utuh sebelum menambah kompleksitas.",
                'image' => null,
                'status' => 'published',
                'meta_title' => 'Menentukan Prioritas Fitur Produk Digital',
                'meta_description' => 'Kerangka sederhana untuk memilih fitur produk digital berdasarkan masalah pengguna dan dampak bisnis.',
                'published_at' => Carbon::parse('2026-09-28'),
                'category' => $category,
                'blog_category_id' => 1,
            ],
        ]);
    }

    public static function paginate(Collection $items, int $perPage): LengthAwarePaginator
    {
        $page = LengthAwarePaginator::resolveCurrentPage();

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }

    public static function findBySlug(Collection $items, string $slug): ?Fluent
    {
        $item = $items->first(fn (Fluent $entry) => $entry->slug === $slug);

        return $item instanceof Fluent ? $item : null;
    }

    private static function items(array $items): Collection
    {
        return collect($items)->map(fn (array $item) => new Fluent($item));
    }
}
