<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // Dashboard
            [
                'name' => 'View Dashboard',
                'description' => 'Allows access to the dashboard.'
            ],

            // Users
            [
                'name' => 'View Users',
                'description' => 'Allows viewing users.'
            ],
            [
                'name' => 'Create User',
                'description' => 'Allows creating users.'
            ],
            [
                'name' => 'Edit User',
                'description' => 'Allows editing users.'
            ],
            [
                'name' => 'Delete User',
                'description' => 'Allows deleting users.'
            ],

            // Roles
            [
                'name' => 'View Roles',
                'description' => 'Allows viewing roles.'
            ],
            [
                'name' => 'Create Role',
                'description' => 'Allows creating roles.'
            ],
            [
                'name' => 'Edit Role',
                'description' => 'Allows editing roles.'
            ],
            [
                'name' => 'Delete Role',
                'description' => 'Allows deleting roles.'
            ],

            // Permissions
            [
                'name' => 'View Permissions',
                'description' => 'Allows viewing permissions.'
            ],
            [
                'name' => 'Create Permission',
                'description' => 'Allows creating permissions.'
            ],
            [
                'name' => 'Edit Permission',
                'description' => 'Allows editing permissions.'
            ],
            [
                'name' => 'Delete Permission',
                'description' => 'Allows deleting permissions.'
            ],

            // Categories
            [
                'name' => 'View Categories',
                'description' => 'Allows viewing categories.'
            ],
            [
                'name' => 'Add Category',
                'description' => null
            ],
            [
                'name' => 'Edit Category',
                'description' => null
            ],
            [
                'name' => 'Delete Category',
                'description' => null
            ],

            // Brands
            [
                'name' => 'View Brands',
                'description' => null
            ],
            [
                'name' => 'Add Brand',
                'description' => null
            ],
            [
                'name' => 'Edit Brand',
                'description' => null
            ],
            [
                'name' => 'Delete Brand',
                'description' => null
            ],

            // Products
            [
                'name' => 'View Products',
                'description' => null
            ],
            [
                'name' => 'Add Product',
                'description' => null
            ],
            [
                'name' => 'Edit Product',
                'description' => null
            ],
            [
                'name' => 'Delete Product',
                'description' => null
            ],

        ];


        foreach ($permissions as $permission) {

            Permission::updateOrCreate(
                [
                    'name' => $permission['name']
                ],
                [
                    'description' => $permission['description']
                ]
            );

        }
    }
}