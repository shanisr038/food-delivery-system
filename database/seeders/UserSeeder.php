<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\City;
use App\Models\Restaurant;
use App\Enums\RoleName;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->createAdminUser();
        $this->createVendorUser();
        $this->createCustomerUser();
    }

    public function createAdminUser(): void
    {
        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);
        
        $admin->roles()->sync(Role::where('name', RoleName::ADMIN->value)->first());
    }

    public function createVendorUser(): void
    {
        
        $vendor = User::create([
            'name'          => 'Restaurant owner',
            'email'         => 'vendor@admin.com',
            'password'      => Hash::make('password'),
            'restaurant_id' => null, 
        ]);

      
        $vendor->roles()->sync(Role::where('name', RoleName::VENDOR->value)->first());

        
        $restaurant = Restaurant::create([
            'city_id'  => 1,
            'owner_id' => $vendor->id,
            'name'     => 'The Italian Bistro',
            'address'  => 'Address 123 Street',
        ]);

      
        $vendor->update(['restaurant_id' => $restaurant->id]);
    }

    public function createCustomerUser(): void
    { 
        $customer = User::create([ 
            'name'     => 'Loyal Customer', 
            'email'    => 'customer@admin.com', 
            'password' => Hash::make('password'), 
        ]); 

        $customer->roles()->sync(Role::where('name', RoleName::CUSTOMER->value)->first()); 
    }
}