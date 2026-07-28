<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition(): array
    {
        $name = $this->faker->name();

        return [
            'name' => $name,
            'slug' => Str::slug($name), // <-- Added slug generation
            'email' => $this->faker->unique()->safeEmail(),
            'biography' => $this->faker->paragraph(),
            'status' => 'active',
        ];
    }
}