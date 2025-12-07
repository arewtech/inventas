<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            LocationSeeder::class,
            AssetSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '081234567890',
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Operator',
            'username' => 'operator',
            'email' => 'operator@gmail.com',
            'phone' => '081123141233',
            'role' => 'operator',
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Kepala Sekolah',
        //     'username' => 'kepala',
        //     'email' => 'kepalasekolah@gmail.com',
        //     'phone' => '081123142323',
        //     'role' => 'kepala_sekolah',
        // ]);

        \App\Models\User::factory()->create([
            'name' => 'Umar Bakri',
            'username' => 'umar',
            'email' => 'umar@gmail.com',
            'phone' => '081234567890',
            'role' => 'user',
        ]);
    }
}
