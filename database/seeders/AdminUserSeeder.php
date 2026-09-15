<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email'=>env('ADMIN_EMAIL','admin@aditech.id')],
            ['name'=>env('ADMIN_NAME','Administrator'),'password'=>Hash::make(env('ADMIN_PASSWORD','ChangeMe123!')),'role'=>'admin']
        );
    }
}
