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
        $admin = User::create([
            'name' => 'Superadmin',
            'email' => 'adhyaksa209@gmail.com',
            'password' => bcrypt('akuadmin456'),
            'role' => 'admin',
            'points' => 0,
        ]);
        $admin->email_verified_at = now();
        $admin->save();

        $member = User::create([
            'name' => 'Adhyaksa',
            'email' => 'adhyaksa.daudi.2405336@students.um.ac.id',
            'password' => bcrypt('adhydaudi005'),
            'role' => 'member',
            'points' => 1500,
        ]);
        $member->email_verified_at = now();
        $member->save();
    }
}
