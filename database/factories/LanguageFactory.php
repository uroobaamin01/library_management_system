<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class LanguageFactory extends Factory
{
    protected $model = Language::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement(['English', 'Urdu', 'Arabic', 'Spanish', 'French']),
            'code' => $this->faker->unique()->languageCode(),
        ];
    }
}