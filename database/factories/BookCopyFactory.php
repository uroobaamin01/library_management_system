<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Shelf;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookCopyFactory extends Factory
{
    protected $model = BookCopy::class;

    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'shelf_id' => function () {
                // Safely fetch or create default shelf if ShelfFactory isn't present
                return Shelf::firstOrCreate(
                    ['code' => 'S1-A'],
                    ['name' => 'Shelf 1', 'capacity' => 50]
                )->id;
            },
            'barcode' => strtoupper($this->faker->unique()->bothify('BC-#####-???')),
            'copy_number' => $this->faker->numberBetween(1, 10),
            'status' => 'available',
            'condition' => 'good',
        ];
    }
}