<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Website Company Profile',
            'Website Toko Produk',
            'Landing Page',
            'Website Katalog',
            'Sistem Informasi UMKM',
            'POS System',
            'Custom Website'
        ];

        foreach ($items as $item) {

            ServiceCategory::updateOrCreate(
                [
                    'slug' => str()->slug($item)
                ],
                [
                    'name' => $item
                ]
            );

        }
    }
}