<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            'demo/B07JDGBX9D_0.jpeg',
            'demo/B07JDGBX9D_3.jpeg',
            'demo/B07JDGBX9D_4.jpeg',
            'demo/B09LHHGC2F_0.jpeg',
            'demo/B0C5LJ2HP3_0.jpeg',
            'demo/B0C6Y9S51X_0.jpeg',
            'demo/B0CCSLJ4CQ_0.jpeg',
            'demo/B0DKNQF47L_0.jpeg',
            'demo/B0F23BR4KV_0.jpeg',
            'demo/B0FC6LNFVK_0.jpeg',
            'demo/B0FG7PHZ4D_0.jpeg',
            'demo/B0FGY2TNK7_0.jpeg',
            'demo/B0FHK334R5_0.jpeg',
        ];

        $products = [
            [
                'sku' => 'MNS-001',
                'name' => 'Classic Oxford Button-Down Shirt',
                'description' => 'Tailored from 100% premium cotton, this timeless Oxford shirt features a button-down collar, chest pocket, and a versatile slim fit perfect for office or casual wear.',
                'purchase_price' => 18.00,
                'sell_price' => 44.00,
                'opening_stock' => 300,
                'current_stock' => 300,
            ],
            [
                'sku' => 'MNS-002',
                'name' => 'Slim Fit Chino Trousers',
                'description' => 'Stretch-cotton chinos with a slim, tapered leg. Available in neutral tones, these trousers transition seamlessly from boardroom to weekend.',
                'purchase_price' => 22.00,
                'sell_price' => 54.00,
                'opening_stock' => 250,
                'current_stock' => 250,
            ],
            [
                'sku' => 'MNS-003',
                'name' => 'Heritage Denim Jacket',
                'description' => 'Washed selvedge denim jacket with a classic trucker silhouette, chest flap pockets, and adjustable waist buttons. Built to age beautifully.',
                'purchase_price' => 38.00,
                'sell_price' => 89.00,
                'opening_stock' => 200,
                'current_stock' => 200,
            ],
            [
                'sku' => 'MNS-004',
                'name' => 'Merino Wool Crew-Neck Sweater',
                'description' => 'Extra-fine 18.5-micron Merino wool for exceptional softness and warmth. Ribbed cuffs and hem, seamless shoulder construction.',
                'purchase_price' => 42.00,
                'sell_price' => 99.00,
                'opening_stock' => 180,
                'current_stock' => 180,
            ],
            [
                'sku' => 'MNS-005',
                'name' => 'Formal Dress Shirt — White',
                'description' => 'Non-iron poplin dress shirt with a spread collar, French cuffs, and hidden button placket. Pairs perfectly with a suit or blazer.',
                'purchase_price' => 24.00,
                'sell_price' => 59.00,
                'opening_stock' => 350,
                'current_stock' => 350,
            ],
            [
                'sku' => 'MNS-006',
                'name' => 'Piqué Polo Shirt',
                'description' => 'Classic two-button piqué polo in moisture-wicking cotton blend. A refined choice for smart-casual occasions.',
                'purchase_price' => 16.00,
                'sell_price' => 39.00,
                'opening_stock' => 400,
                'current_stock' => 400,
            ],
            [
                'sku' => 'MNS-007',
                'name' => 'Tapered Cargo Jogger Pants',
                'description' => 'Relaxed-waist cargo joggers with six-pocket utility styling, drawstring hem, and a brushed-cotton interior for all-day comfort.',
                'purchase_price' => 20.00,
                'sell_price' => 49.00,
                'opening_stock' => 280,
                'current_stock' => 280,
            ],
            [
                'sku' => 'MNS-008',
                'name' => 'Double-Breasted Blazer',
                'description' => 'Peak-lapel double-breasted blazer in a wool-blend fabric. Clean-cut silhouette with structured shoulders and a half-canvas construction.',
                'purchase_price' => 88.00,
                'sell_price' => 199.00,
                'opening_stock' => 120,
                'current_stock' => 120,
            ],
            [
                'sku' => 'MNS-009',
                'name' => 'Reversible Genuine Leather Belt',
                'description' => 'Full-grain leather belt reversible from black to tan. Polished silver-tone buckle, width 35mm, available in sizes 32–44.',
                'purchase_price' => 14.00,
                'sell_price' => 34.00,
                'opening_stock' => 500,
                'current_stock' => 500,
            ],
            [
                'sku' => 'MNS-010',
                'name' => 'Slim Fit Suit Trousers',
                'description' => 'Super-120s wool suit trousers with a flat front, belt loops, and a slim silhouette. Designed to sit at the natural waist.',
                'purchase_price' => 45.00,
                'sell_price' => 109.00,
                'opening_stock' => 160,
                'current_stock' => 160,
            ],
            [
                'sku' => 'MNS-011',
                'name' => 'MA-1 Bomber Jacket',
                'description' => 'Military-inspired MA-1 flight jacket in water-resistant nylon with a bright orange reversible lining, ribbed cuffs, and multiple zip pockets.',
                'purchase_price' => 52.00,
                'sell_price' => 119.00,
                'opening_stock' => 150,
                'current_stock' => 150,
            ],
            [
                'sku' => 'MNS-012',
                'name' => 'Henley Long-Sleeve Tee',
                'description' => 'Three-button placket Henley in a heavyweight 280gsm cotton-spandex blend. Relaxed yet refined — ideal for layering or wearing solo.',
                'purchase_price' => 12.00,
                'sell_price' => 29.00,
                'opening_stock' => 450,
                'current_stock' => 450,
            ],
            [
                'sku' => 'MNS-013',
                'name' => 'Leather Lace-Up Oxford Shoes',
                'description' => 'Full-grain calfskin Oxfords with a Goodyear-welted leather sole. Blind broguing detail, antique oak finish, and a padded insole.',
                'purchase_price' => 72.00,
                'sell_price' => 169.00,
                'opening_stock' => 100,
                'current_stock' => 100,
            ],
            [
                'sku' => 'MNS-014',
                'name' => 'Pull-On Chelsea Boots',
                'description' => 'Suede Chelsea boots with elastic side gussets, a stacked leather heel, and a durable rubber toe cap. Easy slip-on style meets smart versatility.',
                'purchase_price' => 64.00,
                'sell_price' => 149.00,
                'opening_stock' => 120,
                'current_stock' => 120,
            ],
            [
                'sku' => 'MNS-015',
                'name' => 'Low-Top Leather Sneakers',
                'description' => 'Clean-cut low-top sneakers in tumbled leather with a vulcanised rubber sole, tonal laces, and a cushioned ortholite footbed.',
                'purchase_price' => 44.00,
                'sell_price' => 99.00,
                'opening_stock' => 200,
                'current_stock' => 200,
            ],
            [
                'sku' => 'MNS-016',
                'name' => 'Wool-Blend Overcoat',
                'description' => 'Season-spanning overcoat in a 70% wool blend with a notch lapel, half-belt back detail, and a satin lining. Knee-length, clean-cut profile.',
                'purchase_price' => 110.00,
                'sell_price' => 249.00,
                'opening_stock' => 90,
                'current_stock' => 90,
            ],
            [
                'sku' => 'MNS-017',
                'name' => 'Athletic Tapered Track Pants',
                'description' => 'Performance stretch track pants with a four-way stretch fabric, zip ankle cuffs, side pockets, and a hidden drawstring waistband.',
                'purchase_price' => 19.00,
                'sell_price' => 44.00,
                'opening_stock' => 300,
                'current_stock' => 300,
            ],
            [
                'sku' => 'MNS-018',
                'name' => 'Quarter-Zip Fleece Pullover',
                'description' => 'Midweight anti-pill fleece quarter-zip in a relaxed fit. Ideal under a jacket or worn solo during transitional weather.',
                'purchase_price' => 26.00,
                'sell_price' => 59.00,
                'opening_stock' => 220,
                'current_stock' => 220,
            ],
            [
                'sku' => 'MNS-019',
                'name' => 'Graphic Print Oversized T-Shirt',
                'description' => 'Boxy-fit tee in 100% ring-spun cotton with a bold front graphic print. Dropped shoulders, raw-edge hem, double-stitched seams.',
                'purchase_price' => 9.00,
                'sell_price' => 24.00,
                'opening_stock' => 600,
                'current_stock' => 600,
            ],
            [
                'sku' => 'MNS-020',
                'name' => 'Linen Summer Shirt',
                'description' => 'Breathable pure-linen shirt with a camp collar, a relaxed straighthem, and a single chest pocket. The warm-weather wardrobe essential.',
                'purchase_price' => 20.00,
                'sell_price' => 49.00,
                'opening_stock' => 350,
                'current_stock' => 350,
            ],
        ];

        foreach ($products as $index => $product) {
            $product['image'] = $images[$index % count($images)];
            Product::firstOrCreate(['sku' => $product['sku']], $product);
        }
    }
}
