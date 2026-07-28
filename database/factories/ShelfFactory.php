<?php

namespace Database\Factories;

use App\Models\Rack;
use App\Models\Shelf;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShelfFactory extends Factory
{
    protected $model = Shelf::class;

    public function definition(): array
    {
        return [
            'rack_id' => Rack::firstOrCreate(['code' => 'R1'], ['name' => 'Rack 1'])->id,
            'name' => 'Shelf ' . $this->faker->numberBetween(1, 10),
            'code' => strtoupper($this->faker->unique()->bothify('S#-???')),
            'capacity' => 50,
        ];
    }
}