<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::insert([
            [
                'name' => 'Netflix Premium 1 Bulan',
                'category' => 'Streaming',
                'original_price' => 65000,
                'aksespro_price' => 18500,
                'duration_days' => 30,
                'stock' => 15,
                'max_stock' => 20,
                'is_active' => true,
                'description' => 'Akun sharing 1 profile 1 device. Resolusi 4K UHD. Garansi penuh 1 bulan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Spotify Family 1 Bulan',
                'category' => 'Musik',
                'original_price' => 86900,
                'aksespro_price' => 18000,
                'duration_days' => 30,
                'stock' => 10,
                'max_stock' => 10,
                'is_active' => true,
                'description' => 'Invite via link family. Akun private region Indonesia. Anti banned.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Canva Pro 1 Tahun',
                'category' => 'Desain',
                'original_price' => 1000000,
                'aksespro_price' => 8000,
                'duration_days' => 365,
                'stock' => 50,
                'max_stock' => 50,
                'is_active' => true,
                'description' => 'Invite tim Canva Pro. Semua fitur premium terbuka. Legal 100%.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'YouTube Premium 1 Bulan',
                'category' => 'Streaming',
                'original_price' => 139000,
                'aksespro_price' => 4500,
                'duration_days' => 30,
                'stock' => 5,
                'max_stock' => 10,
                'is_active' => true,
                'description' => 'Invite family. Bebas iklan, YouTube Music premium.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ChatGPT Plus 1 Bulan',
                'category' => 'Produktivitas',
                'original_price' => 350000,
                'aksespro_price' => 31000,
                'duration_days' => 30,
                'stock' => 8,
                'max_stock' => 15,
                'is_active' => true,
                'description' => 'Akun sharing bergaransi. Akses fitur GPT-4 dan prioritas akses.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
