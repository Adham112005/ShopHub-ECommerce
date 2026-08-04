<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [

            [
                'name' => 'Apple',
                'description' => null,
                'status' => 1,
            ],

            [
                'name' => 'Samsung',
                'description' => null,
                'status' => 1,
            ],

            [
                'name' => 'Dell',
                'description' => null,
                'status' => 1,
            ],

            [
                'name' => 'Sony',
                'description' => null,
                'status' => 1,
            ],

            [
                'name' => 'Microsoft',
                'description' => null,
                'status' => 1,
            ],

            [
                'name' => 'LG',
                'description' => null,
                'status' => 1,
            ],

            [
                'name' => 'Nike',
                'description' => null,
                'status' => 1,
            ],

            [
                'name' => 'Adidas',
                'description' => null,
                'status' => 1,
            ],

            [
                'name' => "L'Oréal",
                'description' => null,
                'status' => 1,
            ],

            [
                'name' => 'Dove',
                'description' => null,
                'status' => 1,
            ],

            [
                'name' => 'Wilson',
                'description' => null,
                'status' => 1,
            ],

            [
                'name' => 'Avery',
                'description' => null,
                'status' => 1,
            ],

            [
                'name' => 'Pearson',
                'description' => null,
                'status' => 1,
            ],

            [
                'name' => 'IKEA',
                'description' => null,
                'status' => 1,
            ],

            [
                'name' => 'HP',
                'description' => null,
                'status' => 1,
            ],

        ];


        foreach ($brands as $brand) {

            Brand::updateOrCreate(
                [
                    'name' => $brand['name']
                ],
                $brand
            );

        }
    }
}