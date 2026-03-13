<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::firstOrCreate(
            ['sku' => 'PROD-001'],
            [
                'name' => 'Sample Product',
                'description' => 'A sample product for demonstration purposes.',
                'purchase_price' => 100.00,
                'sell_price' => 200.00,
                'opening_stock' => 50,
                'current_stock' => 50,
            ]
        );
    }
}
