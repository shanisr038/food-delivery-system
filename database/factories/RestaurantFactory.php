<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    public function definition(): array
    {
        return [
           
            'city_id' => City::inRandomOrder()->first()->id ?? City::factory(),
            'name'    => fake()->company() . ' Kitchen',
            'address' => fake()->address(),
        ];
    }
}