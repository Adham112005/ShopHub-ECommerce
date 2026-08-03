<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's users.
     */
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'Super Admin')->firstOrFail();

        User::updateOrCreate(
            [
                'email' => 'aaa@aaa.com',
            ],
            [
                'name' => 'Adham',
                'email' => 'aaa@aaa.com',
                'phone' => '01000000000',
                'password' => '123456',
                'role_id' => $superAdminRole->id,
                'status' => true,
            ]
        );
    }
}
