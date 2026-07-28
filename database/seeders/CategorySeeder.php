<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Computer Science & Software', 'slug' => 'computer-science-software', 'description' => 'Books covering programming, software engineering, databases, and algorithms.'],
            ['name' => 'Fiction & Literature', 'slug' => 'fiction-literature', 'description' => 'Classic modern novels, historical fiction, and short story collections.'],
            ['name' => 'Physics & Mathematics', 'slug' => 'physics-mathematics', 'description' => 'Textbooks and foundational treatises on algebra, calculus, and mechanics.'],
            ['name' => 'Business & Economics', 'slug' => 'business-economics', 'description' => 'Corporate strategy, macroeconomics, finance, and leadership guides.'],
            ['name' => 'History & World Wars', 'slug' => 'history-world-wars', 'description' => 'Historical archives, biographies of political figures, and world events.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                array_merge($category, ['status' => 'active', 'created_by' => 1])
            );
        }
    }
}