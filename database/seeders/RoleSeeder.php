<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::updateOrCreate(
            ['slug' => 'super-admin'],
            [
                'name' => 'Super Admin',
                'description' => 'Complete control over the entire system.',
                'status' => 'active',
            ]
        );

        $admin = Role::updateOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Administrator',
                'description' => 'Administrative control over library catalog and settings.',
                'status' => 'active',
            ]
        );

        // Assign all permissions to Super Admin
        $allPermissions = Permission::pluck('id')->toArray();
        $superAdmin->permissions()->sync($allPermissions);

        // Assign standard admin permissions (excluding full system re-configuration)
        $adminPermissions = Permission::whereIn('module', ['Dashboard', 'Books', 'Categories', 'Authors', 'Publishers', 'Locations'])->pluck('id')->toArray();
        $admin->permissions()->sync($adminPermissions);
    }
}