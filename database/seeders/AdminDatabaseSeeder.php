<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            LanguageSeeder::class,
            AuthorSeeder::class,
            PublisherSeeder::class,
            SettingSeeder::class,
        ]);
    }
}