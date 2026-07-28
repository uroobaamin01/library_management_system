<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Dashboard
            ['name' => 'View Dashboard', 'slug' => 'dashboard.view', 'module' => 'Dashboard', 'description' => 'Access admin dashboard statistics'],

            // Books
            ['name' => 'View Books', 'slug' => 'books.view', 'module' => 'Books', 'description' => 'View book records'],
            ['name' => 'Create Books', 'slug' => 'books.create', 'module' => 'Books', 'description' => 'Create new book records'],
            ['name' => 'Edit Books', 'slug' => 'books.edit', 'module' => 'Books', 'description' => 'Update existing book records'],
            ['name' => 'Delete Books', 'slug' => 'books.delete', 'module' => 'Books', 'description' => 'Soft delete book records'],

            // Categories
            ['name' => 'View Categories', 'slug' => 'categories.view', 'module' => 'Categories', 'description' => 'View category list'],
            ['name' => 'Create Categories', 'slug' => 'categories.create', 'module' => 'Categories', 'description' => 'Add new book category'],
            ['name' => 'Edit Categories', 'slug' => 'categories.edit', 'module' => 'Categories', 'description' => 'Update book category'],
            ['name' => 'Delete Categories', 'slug' => 'categories.delete', 'module' => 'Categories', 'description' => 'Delete book category'],

            // Authors
            ['name' => 'View Authors', 'slug' => 'authors.view', 'module' => 'Authors', 'description' => 'View author profiles'],
            ['name' => 'Create Authors', 'slug' => 'authors.create', 'module' => 'Authors', 'description' => 'Add new author profile'],
            ['name' => 'Edit Authors', 'slug' => 'authors.edit', 'module' => 'Authors', 'description' => 'Update author profile'],
            ['name' => 'Delete Authors', 'slug' => 'authors.delete', 'module' => 'Authors', 'description' => 'Delete author profile'],

            // Publishers
            ['name' => 'View Publishers', 'slug' => 'publishers.view', 'module' => 'Publishers', 'description' => 'View publisher list'],
            ['name' => 'Create Publishers', 'slug' => 'publishers.create', 'module' => 'Publishers', 'description' => 'Add new publisher'],
            ['name' => 'Edit Publishers', 'slug' => 'publishers.edit', 'module' => 'Publishers', 'description' => 'Update publisher record'],
            ['name' => 'Delete Publishers', 'slug' => 'publishers.delete', 'module' => 'Publishers', 'description' => 'Delete publisher record'],

            // Racks & Shelves
            ['name' => 'Manage Racks', 'slug' => 'racks.manage', 'module' => 'Locations', 'description' => 'Manage rack units'],
            ['name' => 'Manage Shelves', 'slug' => 'shelves.manage', 'module' => 'Locations', 'description' => 'Manage shelf levels'],

            // System Settings & Logs
            ['name' => 'Manage Settings', 'slug' => 'settings.manage', 'module' => 'System', 'description' => 'Update application settings'],
            ['name' => 'View Logs', 'slug' => 'logs.view', 'module' => 'System', 'description' => 'View system activity logs'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
    }
}