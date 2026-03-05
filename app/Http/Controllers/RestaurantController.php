<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function show(\App\Models\Restaurant $restaurant)
{
    
    return inertia('Restaurant', [
       'restaurant' => $restaurant->load(['city', 'categories.products']),
    ]);
}
}
