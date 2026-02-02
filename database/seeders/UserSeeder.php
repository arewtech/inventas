<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '08123456789',
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Operator Asset
        User::create([
            'name' => 'Operator Asset',
            'username' => 'operator-asset',
            'email' => 'operator.asset@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '08123456788',
            'role' => 'operator-asset',
            'status' => 'active',
        ]);

        // Operator Letter
        User::create([
            'name' => 'Operator Letter',
            'username' => 'operator-letter',
            'email' => 'operator.letter@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '08123456787',
            'role' => 'operator-letter',
            'status' => 'active',
        ]);

        // Kepala Sekolah
        User::create([
            'name' => 'Kepala Sekolah',
            'username' => 'kepala-sekolah',
            'email' => 'kepala.sekolah@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '08123456786',
            'role' => 'kepala_sekolah',
            'status' => 'active',
        ]);
    }
}
