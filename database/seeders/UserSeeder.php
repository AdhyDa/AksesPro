<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Superadmin',
            'email' => 'adhyaksa209@gmail.com',
            'password' => bcrypt('akuadmin456'),
            'role' => 'admin',
            'points' => 0,
        ]);

        User::create([
            'name' => 'Adhyaksa',
            'email' => 'adhyaksa.daudi.2405336@students.um.ac.id',
            'password' => bcrypt('adhydaudi005'),
            'role' => 'member',
            'points' => 1500,
        ]);
    }
}
