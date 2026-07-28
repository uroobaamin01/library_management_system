<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Category;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Rack;
use App\Models\Setting;
use App\Models\Shelf;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Core Administrative Accounts
        $this->call(AdminUserSeeder::class);

        // 2. Seed Default Settings
        $defaultSettings = [
            'system_title' => 'LMS Portal',
            'max_books_allowed' => '3',
            'fine_rate_per_day' => '1.00',
            'return_due_days' => '14',
        ];

        foreach ($defaultSettings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 3. Seed Physical Storage Structure
        $rack = Rack::create(['name' => 'Main Library - Section A', 'code' => 'RACK-A', 'description' => 'Computer Science & Tech']);
        $shelf = Shelf::create(['rack_id' => $rack->id, 'name' => 'Level 1', 'code' => 'RACK-A-S1', 'capacity' => 100]);

        // 4. Seed Foreign Key Dependencies
        $languages = collect(['English', 'Spanish', 'French', 'German'])->map(function ($lang) {
            return Language::create(['name' => $lang, 'code' => strtolower(substr($lang, 0, 2))]);
        });

        $categories = Category::factory(5)->create();
        $authors = Author::factory(10)->create();
        $publishers = Publisher::factory(5)->create();

        // 5. Seed Catalog Books with Copies
        Book::factory(15)->create([
            'category_id' => fn() => $categories->random()->id,
            'author_id' => fn() => $authors->random()->id,
            'publisher_id' => fn() => $publishers->random()->id,
            'language_id' => fn() => $languages->random()->id,
        ])->each(function ($book) use ($shelf) {
            BookCopy::factory(3)->create([
                'book_id' => $book->id,
                'shelf_id' => $shelf->id,
            ]);
        });
    }
}