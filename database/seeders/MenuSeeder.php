<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\User;
use App\Enums\RoleName;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get the Vendor User (Should exist from UserSeeder)
        $vendor = User::where('email', 'vendor@admin.com')->first();
        
        if (!$vendor) {
            $vendor = User::create([
                'name' => 'Italian Chef',
                'email' => 'vendor@admin.com',
                'password' => Hash::make('password'),
            ]);
            $vendor->roles()->sync(Role::where('name', RoleName::VENDOR->value)->first());
        }

        // 2. Ensure they have a Restaurant
        $restaurant = $vendor->restaurant()->firstOrCreate([
            'name' => 'The Italian Bistro',
        ], [
            'city_id' => 1, 
            'address' => '456 Pasta Lane',
            'owner_id' => $vendor->id,
        ]);

        // 3. Create Sample Categories and Products
        $categories = [
            'Pizza' => [
                ['name' => 'Margherita', 'price' => 1200],
                ['name' => 'Pepperoni', 'price' => 1550],
                ['name' => 'Quattro Formaggi', 'price' => 1800],
            ],
            'Pasta' => [
                ['name' => 'Carbonara', 'price' => 1400],
                ['name' => 'Bolognese', 'price' => 1350],
            ],
            'Drinks' => [
                ['name' => 'Coca Cola', 'price' => 250],
                ['name' => 'Mineral Water', 'price' => 150],
            ],
        ];

        foreach ($categories as $catName => $products) {
            $category = Category::create([
                'restaurant_id' => $restaurant->id,
                'name' => $catName,
            ]);

            foreach ($products as $prodData) {
                
                Product::create([
                    'restaurant_id' => $restaurant->id, 
                    'category_id'   => $category->id,
                    'name'          => $prodData['name'],
                    'price'         => $prodData['price'],
                ]);
            }
        }
    }
}