<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Portfolio;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        foreach([
            ['title'=>'Website Company Profile UMKM','slug'=>'website-company-profile-umkm','category'=>'Website','description'=>'Website profil bisnis profesional.','features'=>'Profil bisnis, layanan, kontak.','technology'=>'Laravel, MySQL'],
            ['title'=>'Sistem Informasi Bisnis','slug'=>'sistem-informasi-bisnis','category'=>'System','description'=>'Sistem pengelolaan data bisnis.','features'=>'Dashboard, laporan, manajemen data.','technology'=>'Laravel, MySQL'],
        ] as $data){
            Portfolio::updateOrCreate(['slug'=>$data['slug']],$data);
        }
    }
}
