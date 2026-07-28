<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@lms.com'],
            [
                'name' => 'System Super Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        
        User::updateOrCreate(
            ['email' => 'librarian@lms.com'],
            [
                'name' => 'Head Librarian',
                'password' => Hash::make('password123'),
                'role' => 'librarian',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}