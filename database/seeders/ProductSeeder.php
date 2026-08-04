<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [

            [
                'category_id'=>4,
                'brand_id'=>2,
                'name'=>'iPhone 15 Pro',
                'sku'=>'APP-IP15P-256',
                'price'=>35467,
                'discount_price'=>null,
                'quantity'=>18,
                'max_order_quantity'=>2,
                'image'=>'products/iphone15pro.jpg',
                'description'=>'Apple iPhone 15 Pro with A17 Pro chip, 256GB storage.',
                'featured'=>1,
                'status'=>1,
            ],

            [
                'category_id'=>4,
                'brand_id'=>3,
                'name'=>'Galaxy S25 Ultra',
                'sku'=>'SAM-S25U-512',
                'price'=>1199.99,
                'discount_price'=>null,
                'quantity'=>18,
                'max_order_quantity'=>2,
                'image'=>'products/galaxy-s25.jpg',
                'description'=>'Premium Android smartphone with AI-powered features.',
                'featured'=>0,
                'status'=>1,
            ],

            [
                'category_id'=>2,
                'brand_id'=>4,
                'name'=>'Dell XPS 13',
                'sku'=>'DEL-XPS13-I7',
                'price'=>1399.99,
                'discount_price'=>null,
                'quantity'=>12,
                'max_order_quantity'=>1,
                'image'=>'products/dell-xps13.jpg',
                'description'=>'Lightweight ultrabook with Intel Core processor.',
                'featured'=>0,
                'status'=>1,
            ],

            [
                'category_id'=>2,
                'brand_id'=>2,
                'name'=>'MacBook Air M4',
                'sku'=>'APP-MBA-M4',
                'price'=>1299.99,
                'discount_price'=>null,
                'quantity'=>10,
                'max_order_quantity'=>1,
                'image'=>'products/macbook-air-m4.jpg',
                'description'=>'Thin and lightweight laptop powered by Apple M4 chip.',
                'featured'=>0,
                'status'=>1,
            ],

            [
                'category_id'=>5,
                'brand_id'=>5,
                'name'=>'PlayStation 5',
                'sku'=>'SON-PS5-SLIM',
                'price'=>4999.99,
                'discount_price'=>4499.99,
                'quantity'=>18,
                'max_order_quantity'=>1,
                'image'=>'products/ps5.jpg',
                'description'=>'Next-generation gaming console with ultra-fast SSD.',
                'featured'=>1,
                'status'=>1,
            ],

            [
                'category_id'=>5,
                'brand_id'=>6,
                'name'=>'Xbox Series X',
                'sku'=>'MS-XBOX-X',
                'price'=>10999.99,
                'discount_price'=>null,
                'quantity'=>15,
                'max_order_quantity'=>3,
                'image'=>'products/xbox-series-x.jpg',
                'description'=>'Powerful gaming console offering fast load times.',
                'featured'=>0,
                'status'=>1,
            ],

            [
                'category_id'=>1,
                'brand_id'=>7,
                'name'=>'LG Smart TV 55"',
                'sku'=>'LG-TV55-4K',
                'price'=>699.99,
                'discount_price'=>499.99,
                'quantity'=>4,
                'max_order_quantity'=>1,
                'image'=>'products/lg-tv.jpg',
                'description'=>'55-inch 4K UHD Smart TV with webOS.',
                'featured'=>1,
                'status'=>1,
            ],

            [
                'category_id'=>7,
                'brand_id'=>8,
                'name'=>'Nike Air Max 270',
                'sku'=>'NIK-AM270',
                'price'=>149.99,
                'discount_price'=>129.99,
                'quantity'=>35,
                'max_order_quantity'=>1,
                'image'=>'products/nike-airmax.jpg',
                'description'=>'Stylish sneakers featuring Air Max cushioning.',
                'featured'=>1,
                'status'=>1,
            ],

            [
                'category_id'=>10,
                'brand_id'=>13,
                'name'=>'Atomic Habits',
                'sku'=>'BK-ATOMIC',
                'price'=>18.99,
                'discount_price'=>null,
                'quantity'=>28,
                'max_order_quantity'=>1,
                'image'=>'products/atomic-habits.jpg',
                'description'=>'Best-selling self-improvement book by James Clear.',
                'featured'=>0,
                'status'=>1,
            ],

            [
                'category_id'=>10,
                'brand_id'=>14,
                'name'=>'Clean Code',
                'sku'=>'BK-CLEANCODE',
                'price'=>42.99,
                'discount_price'=>25.99,
                'quantity'=>19,
                'max_order_quantity'=>2,
                'image'=>'products/clean-code.jpg',
                'description'=>'Essential programming book by Robert C. Martin.',
                'featured'=>0,
                'status'=>1,
            ],

        ];


        foreach($products as $product)
        {
            Product::updateOrCreate(
                [
                    'sku'=>$product['sku']
                ],
                $product
            );
        }
    }
}