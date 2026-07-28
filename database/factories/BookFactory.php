<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Language;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $title = ucfirst($this->faker->unique()->words(3, true));

        return [
            'category_id' => Category::factory(),
            'author_id' => Author::factory(),
            'publisher_id' => Publisher::factory(),
            'language_id' => function () {
                // Safely fetch or create default language if factory isn't available
                return Language::firstOrCreate(
                    ['code' => 'en'],
                    ['name' => 'English']
                )->id;
            },
            'title' => $title,
            'slug' => Str::slug($title),
            'isbn' => $this->faker->unique()->isbn13(),
            'edition' => $this->faker->numberBetween(1, 5),
            'publish_year' => $this->faker->year(),
            'price' => $this->faker->randomFloat(2, 10, 150),
            'summary' => $this->faker->paragraphs(2, true),
            'status' => 'available',
        ];
    }
}