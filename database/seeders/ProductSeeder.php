<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("products")->insert([
            [
                'product_id' => Str::uuid(),
                'name' => 'Example',
                'product_type' => 1,
                'category_type' => 1,
                'price' => 1250000,
                'discount' => 80,
                'image_url' => json_encode(['/images/product-image/goodie-bag.jpg', '/images/product-image/tumbler.jpg']),
                'detail' => json_encode(['weight' => '20kg', 'size' => 'L']),
                'description' => "This Tumbler made with your mythical heavenly Freshly rod below your abdomen",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => Str::uuid(),
                'name' => 'MUG',
                'product_type' => 1,
                'category_type' => 1,
                'price' => 1200000,
                'discount' => 10,
                'image_url' => json_encode(['/images/product-image/mug-mockup.jpg', '/images/product-image/tumbler.jpg']),
                'detail' => json_encode([]),
                'description' => "This is just an example",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => Str::uuid(),
                'name' => 'Example Tumbler2',
                'product_type' => 1,
                'category_type' => 1,
                'price' => 1200000,
                'discount' => 10,
                'image_url' => json_encode(['/images/product-image/tumbler.jpg', '/images/product-image/tumbler.jpg']),
                'detail' => json_encode([]),
                'description' => "This is just an example",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => Str::uuid(),
                'name' => 'Example Tumbler3',
                'product_type' => 1,
                'category_type' => 1,
                'price' => 1200000,
                'discount' => 10,
                'image_url' => json_encode(['/images/product-image/tumbler.jpg']),
                'detail' => json_encode([]),
                'description' => "This is just an example",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => Str::uuid(),
                'name' => 'Example Tumbler4',
                'product_type' => 1,
                'category_type' => 1,
                'price' => 1200000,
                'discount' => 10,
                'image_url' => json_encode(['/images/product-image/tumbler.jpg']),
                'detail' => json_encode([]),
                'description' => "This is just an example",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => Str::uuid(),
                'name' => 'Example Tumbler5',
                'product_type' => 1,
                'category_type' => 1,
                'price' => 1200000,
                'discount' => 10,
                'image_url' => json_encode(['/images/product-image/tumbler.jpg']),
                'detail' => json_encode([]),
                'description' => "This is just an example",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => Str::uuid(),
                'name' => 'Example Tumbler6',
                'product_type' => 1,
                'category_type' => 1,
                'price' => 1200000,
                'discount' => 10,
                'image_url' => json_encode(['/images/product-image/tumbler.jpg']),
                'detail' => json_encode([]),
                'description' => "This is just an example",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
