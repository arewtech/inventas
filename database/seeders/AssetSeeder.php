<?php

namespace Database\Seeders;

use App\Models\Asset;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = [
            [
                'name' => 'Laptop HP ProBook',
                'category_id' => 2,
                'location_id' => 1,
                'quantity' => 10,
                'condition' => 'baik',
                'description' => 'Laptop untuk penggunaan administrasi dan pengajaran',
                'image' => null,
                'additional_info' => 'Kondisi baik, garansi sampai 2025',
            ],
            [
                'name' => 'Printer Epson L3150',
                'category_id' => 2,
                'location_id' => 2,
                'quantity' => 1,
                'condition' => 'rusak',
                'description' => 'Printer multifungsi untuk keperluan kantor',
                'image' => null,
                'additional_info' => 'Dengan fitur scan dan fotokopi',
            ],
        ];

        foreach ($assets as $asset) {
            // Generate a random 20-character alphanumeric string for asset_number
            $asset['asset_number'] = Str::lower(Str::random(20));

            // Create the asset first
            $createdAsset = Asset::create($asset);

            // Now update the QR code URL using the generated asset_number
            // http://192.168.151.251:8000 || http://inventarisku.test
            $assetUrl = 'http://192.168.1.41:8000' . '/asset/' . $createdAsset->asset_number . '/view';
            $createdAsset->update(['qr_code' => $assetUrl]);
        }
    }
}
