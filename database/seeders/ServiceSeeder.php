<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [

            [
                'name' => 'Website Company Profile',
                'slug' => 'website-company-profile',
                'short_description' => 'Website profesional untuk meningkatkan kredibilitas bisnis.',
                'description' => 'Website company profile membantu bisnis memperkenalkan perusahaan, layanan, keunggulan, dan informasi penting kepada calon pelanggan secara profesional.',
                'target_user' => 'UMKM, perusahaan jasa, startup, organisasi, dan bisnis yang membutuhkan kehadiran digital profesional.',
                'problem' => 'Bisnis belum memiliki media resmi untuk membangun kepercayaan dan memberikan informasi kepada pelanggan.',
                'features' => 'Profil bisnis, halaman layanan, galeri, kontak WhatsApp, SEO basic, responsive design.',
            ],

            [
                'name' => 'Website Toko Produk',
                'slug' => 'website-toko-produk',
                'short_description' => 'Website untuk menampilkan dan menjual produk secara online.',
                'description' => 'Website toko produk membantu bisnis memiliki katalog penjualan online dengan informasi produk yang mudah diakses pelanggan.',
                'target_user' => 'UMKM retail, produsen, distributor, dan bisnis yang menjual produk fisik.',
                'problem' => 'Penjualan masih bergantung pada media sosial tanpa katalog produk yang terstruktur.',
                'features' => 'Katalog produk, detail produk, pencarian, WhatsApp order, integrasi pembayaran.',
            ],

            [
                'name' => 'Landing Page',
                'slug' => 'landing-page',
                'short_description' => 'Halaman promosi untuk produk, jasa, atau campaign.',
                'description' => 'Landing page dirancang untuk meningkatkan fokus pengunjung terhadap satu produk atau layanan tertentu.',
                'target_user' => 'Bisnis yang menjalankan promosi digital, iklan, atau campaign.',
                'problem' => 'Promosi digital belum memiliki halaman khusus untuk meningkatkan konversi.',
                'features' => 'Hero section, CTA, formulir leads, testimonial, tracking dasar.',
            ],

            [
                'name' => 'Website Katalog',
                'slug' => 'website-katalog',
                'short_description' => 'Katalog digital untuk menampilkan banyak produk.',
                'description' => 'Website katalog membantu bisnis menampilkan banyak produk tanpa harus langsung menggunakan sistem transaksi online.',
                'target_user' => 'Distributor, supplier, manufaktur, dan bisnis dengan banyak produk.',
                'problem' => 'Informasi produk masih tersebar dan sulit dikelola.',
                'features' => 'Kategori produk, filter, detail produk, galeri, inquiry pelanggan.',
            ],

            [
                'name' => 'Sistem Informasi UMKM',
                'slug' => 'sistem-informasi-umkm',
                'short_description' => 'Sistem digital untuk membantu pengelolaan bisnis.',
                'description' => 'Sistem informasi membantu bisnis mengelola data operasional secara lebih rapi dan terintegrasi.',
                'target_user' => 'UMKM berkembang yang membutuhkan sistem internal.',
                'problem' => 'Pengelolaan data masih manual menggunakan spreadsheet.',
                'features' => 'Manajemen data, laporan, dashboard, user management.',
            ],

            [
                'name' => 'POS System',
                'slug' => 'pos-system',
                'short_description' => 'Sistem kasir dan operasional bisnis.',
                'description' => 'POS membantu bisnis mengelola transaksi penjualan dan laporan operasional.',
                'target_user' => 'Toko retail, restoran, kafe, dan usaha layanan.',
                'problem' => 'Pencatatan transaksi belum terintegrasi.',
                'features' => 'Kasir, transaksi, laporan penjualan, stok produk.',
            ],

            [
                'name' => 'Custom Website',
                'slug' => 'custom-website',
                'short_description' => 'Pengembangan website sesuai kebutuhan khusus bisnis.',
                'description' => 'Website custom dibuat berdasarkan kebutuhan proses bisnis tertentu.',
                'target_user' => 'Perusahaan yang membutuhkan solusi khusus.',
                'problem' => 'Solusi website standar belum mampu memenuhi kebutuhan bisnis.',
                'features' => 'Custom workflow, integrasi sistem, database, API.',
            ],

        ];


        foreach ($services as $service) {

            Service::updateOrCreate(
                [
                    'slug' => $service['slug']
                ],
                $service
            );

        }
    }
}