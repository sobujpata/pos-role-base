<?php

namespace Database\Seeders;

use App\Models\ShopDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default shop if it doesn't exist
        ShopDetail::firstOrCreate(
            ['id' => 1],
            [
                'shop_name' => 'My Shop',
                'shop_email' => 'shop@example.com',
                'shop_phone' => '+1-800-123-4567',
                'shop_address' => '123 Business Street, City, Country',
                'logo_text' => 'MS',
                'logo' => null,
            ]
        );
    }
}
