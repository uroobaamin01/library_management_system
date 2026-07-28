<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'name' => 'Robert C. Martin',
                'slug' => 'robert-c-martin',
                'biography' => 'Software engineer and author known as "Uncle Bob", co-author of the Agile Manifesto.',
                'email' => 'unclebob@cleancoder.com',
            ],
            [
                'name' => 'Martin Fowler',
                'slug' => 'martin-fowler',
                'biography' => 'British software developer, author, and international speaker on software design.',
                'email' => 'fowler@thoughtworks.com',
            ],
            [
                'name' => 'George Orwell',
                'slug' => 'george-orwell',
                'biography' => 'English novelist, essayist, journalist, and critic noted for 1984 and Animal Farm.',
                'email' => 'contact@orwellfoundation.com',
            ],
            [
                'name' => 'Donald Knuth',
                'slug' => 'donald-knuth',
                'biography' => 'American computer scientist, mathematician, and professor emeritus at Stanford University.',
                'email' => 'knuth@stanford.edu',
            ],
        ];

        foreach ($authors as $author) {
            Author::updateOrCreate(
                ['slug' => $author['slug']],
                array_merge($author, ['status' => 'active', 'created_by' => 1])
            );
        }
    }
}