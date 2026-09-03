<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        foreach([
            ['name'=>'Website Toko Online UMKM','slug'=>'website-toko-online-umkm','description'=>'Website penjualan online dengan katalog produk dan integrasi WhatsApp.','price'=>3500000],
            ['name'=>'POS Kasir Digital','slug'=>'pos-kasir-digital','description'=>'Sistem kasir digital untuk transaksi dan laporan bisnis.','price'=>5000000],
            ['name'=>'Website Katalog Produk','slug'=>'website-katalog-produk','description'=>'Katalog digital profesional untuk menampilkan produk.','price'=>2500000],
        ] as $data){
            Product::updateOrCreate(['slug'=>$data['slug']],$data);
        }
    }
}
