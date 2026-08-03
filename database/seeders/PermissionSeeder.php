<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's permissions.
     */
    public function run(): void
    {
        $permissions = [

            // Dashboard
            [
                'name' => 'View Dashboard',
                'description' => 'Allows access to the dashboard.',
            ],

            // Users
            [
                'name' => 'View Users',
                'description' => 'Allows viewing users.',
            ],
            [
                'name' => 'Create User',
                'description' => 'Allows creating users.',
            ],
            [
                'name' => 'Edit User',
                'description' => 'Allows editing users.',
            ],
            [
                'name' => 'Delete User',
                'description' => 'Allows deleting users.',
            ],

            // Roles
            [
                'name' => 'View Roles',
                'description' => 'Allows viewing roles.',
            ],
            [
                'name' => 'Create Role',
                'description' => 'Allows creating roles.',
            ],
            [
                'name' => 'Edit Role',
                'description' => 'Allows editing roles.',
            ],
            [
                'name' => 'Delete Role',
                'description' => 'Allows deleting roles.',
            ],

            // Permissions
            [
                'name' => 'View Permissions',
                'description' => 'Allows viewing permissions.',
            ],
            [
                'name' => 'Create Permission',
                'description' => 'Allows creating permissions.',
            ],
            [
                'name' => 'Edit Permission',
                'description' => 'Allows editing permissions.',
            ],
            [
                'name' => 'Delete Permission',
                'description' => 'Allows deleting permissions.',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
