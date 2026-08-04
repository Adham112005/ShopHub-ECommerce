<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::where('name','Super Admin')->first();

        $permissions = Permission::all();

        foreach($permissions as $permission){

            $role->permissions()->syncWithoutDetaching([
                $permission->id
            ]);

        }
    }
}