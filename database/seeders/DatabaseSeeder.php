<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([

            // Roles & Permissions
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,

            // Admin User
            UserSeeder::class,

            // Store Data
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,

        ]);
    }
}