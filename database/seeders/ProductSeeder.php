<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Website Toko Online UMKM',
                'slug' => 'website-toko-online-umkm',
                'description' => 'Website penjualan online dengan katalog produk dan integrasi WhatsApp.',
                'price' => 3500000,
                'image' => 'images/showcase/demo-toko-online.webp',
            ],
            [
                'name' => 'POS Kasir Digital',
                'slug' => 'pos-kasir-digital',
                'description' => 'Sistem kasir digital untuk transaksi dan laporan bisnis.',
                'price' => 5000000,
                'image' => 'images/showcase/demo-pos-kasir.webp',
            ],
            [
                'name' => 'Website Katalog Produk',
                'slug' => 'website-katalog-produk',
                'description' => 'Katalog digital profesional untuk menampilkan produk.',
                'price' => 2500000,
                'image' => 'images/showcase/demo-katalog.webp',
            ],
            [
                'name' => 'Demo Toko Sepatu Online',
                'slug' => 'demo-toko-sepatu-online',
                'description' => 'Demo website toko online sepatu dengan katalog produk digital.',
                'price' => 3000000,
                'image' => 'images/showcase/demo-sepatu.webp',
            ],
            [
                'name' => 'Demo Toko iPhone Online',
                'slug' => 'demo-toko-iphone-online',
                'description' => 'Demo website penjualan iPhone dengan tampilan modern.',
                'price' => 3000000,
                'image' => 'images/showcase/demo-iphone.webp',
            ],
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
