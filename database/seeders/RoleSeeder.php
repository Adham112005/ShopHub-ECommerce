<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [

            [
                'name' => 'Super Admin',
                'description' => 'Full access to the system.'
            ],

            [
                'name' => 'Admin',
                'description' => 'Manage store operations.'
            ],

            [
                'name' => 'Customer',
                'description' => 'Can purchase products.'
            ],

        ];


        foreach ($roles as $role) {

            Role::updateOrCreate(
                [
                    'name' => $role['name']
                ],
                [
                    'description' => $role['description']
                ]
            );

        }
    }
}