<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
            'name' => 'Furnitur',
            'description' => 'Furnitur kantor dan kelas seperti kursi, meja kerja, dan meja'
            ],
            [
            'name' => 'Elektronik',
            'description' => 'Perangkat elektronik seperti komputer, proyektor, dan printer'
            ],
            [
            'name' => 'Alat Tulis',
            'description' => 'Perlengkapan kantor termasuk pulpen, kertas, dan stapler'
            ],
            [
            'name' => 'Alat Pengajaran',
            'description' => 'Bahan pengajaran seperti papan tulis, poster, dan peralatan pendidikan'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}