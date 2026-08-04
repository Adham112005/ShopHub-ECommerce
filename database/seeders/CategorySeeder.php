<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic devices and accessories',
                'status' => 1,
            ],

            [
                'name' => 'Computers',
                'slug' => 'computers',
                'description' => 'Desktop and laptop computers',
                'status' => 1,
            ],

            [
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'description' => 'Mobile phones and accessories',
                'status' => 1,
            ],

            [
                'name' => 'Gaming',
                'slug' => 'gaming',
                'description' => 'Gaming consoles and accessories',
                'status' => 1,
            ],

            [
                'name' => 'Home Appliances',
                'slug' => 'home-appliances',
                'description' => 'Home electrical appliances',
                'status' => 1,
            ],

            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Clothing and fashion products',
                'status' => 1,
            ],

            [
                'name' => 'Beauty',
                'slug' => 'beauty',
                'description' => 'Beauty and personal care',
                'status' => 1,
            ],

            [
                'name' => 'Sports',
                'slug' => 'sports',
                'description' => 'Sports equipment',
                'status' => 1,
            ],

            [
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'Books and educational materials',
                'status' => 1,
            ],

            [
                'name' => 'Office Supplies',
                'slug' => 'office-supplies',
                'description' => 'Office products',
                'status' => 1,
            ],

        ];


        foreach ($categories as $category) {

            Category::updateOrCreate(
                [
                    'slug' => $category['slug']
                ],
                $category
            );

        }
    }
}