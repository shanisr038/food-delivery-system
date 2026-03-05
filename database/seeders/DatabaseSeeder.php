<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            CitySeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
        ]);

       
        $products = Product::factory(7)->state(function (array $attributes, Category $category) {
            return [
                'restaurant_id' => $category->restaurant_id,
            ];
        });

      
        $categories = Category::factory(5)->has($products, 'products');

       
        $restaurant = Restaurant::factory()->has($categories, 'categories');

      
        User::factory(50)
            ->vendor()
            ->has($restaurant, 'restaurant')
            ->create();
    }
}