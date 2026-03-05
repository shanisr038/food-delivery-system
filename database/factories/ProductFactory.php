<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'  => fake()->word() . ' ' . fake()->word(),
            'price' => fake()->numberBetween(500, 5000), 
            'restaurant_id' => \App\Models\Category::factory(), 
        'category_id'   => \App\Models\Category::factory(),
        ];
    }
}
