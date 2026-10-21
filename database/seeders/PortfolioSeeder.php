<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Website Company Profile UMKM',
                'slug' => 'website-company-profile-umkm',
                'category' => 'Website',
                'description' => 'Website profil bisnis profesional dengan informasi layanan, keunggulan, dan alur kontak yang jelas.',
                'features' => 'Profil bisnis, layanan, galeri, formulir kontak, integrasi WhatsApp',
                'technology' => 'Laravel, SQLite, Responsive CSS',
                'image' => 'images/showcase/demo-toko-online.webp',
            ],
            [
                'title' => 'Sistem Informasi Bisnis',
                'slug' => 'sistem-informasi-bisnis',
                'category' => 'Sistem',
                'description' => 'Sistem pengelolaan data bisnis untuk menyatukan proses operasional dan laporan dalam satu panel.',
                'features' => 'Dashboard, laporan, manajemen data, hak akses pengguna',
                'technology' => 'Laravel, SQLite, JavaScript',
                'image' => 'images/showcase/demo-pos-kasir.webp',
            ],
        ];

        foreach ($projects as $data) {
            Portfolio::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
