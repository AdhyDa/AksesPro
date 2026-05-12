<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Superadmin',
            'email' => 'admin@aksespro.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'points' => 0,
        ]);

        \App\Models\User::create([
            'name' => 'Budi Mahasiswa',
            'email' => 'budi@student.ac.id',
            'password' => bcrypt('password'),
            'role' => 'member',
            'points' => 1500,
        ]);

        \App\Models\User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@student.ac.id',
            'password' => bcrypt('password'),
            'role' => 'member',
            'points' => 500,
        ]);

        \App\Models\User::create([
            'name' => 'Andi Wijaya',
            'email' => 'andi@student.ac.id',
            'password' => bcrypt('password'),
            'role' => 'member',
            'points' => 0,
        ]);
    }
}
