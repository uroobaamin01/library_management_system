<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@library.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('Admin@12345'),
                'phone' => '+1 (555) 019-2834',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $superAdminRole = Role::where('slug', 'super-admin')->first();
        if ($superAdminRole) {
            $admin->roles()->sync([$superAdminRole->id]);
        }
    }
}