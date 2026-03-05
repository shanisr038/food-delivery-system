<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        return Inertia::render('Customer/Cart');
    }

    public function add(Product $product): RedirectResponse
    {
        // 1. Eager load relationships safely
        $product->load('category.restaurant');

        // 2. Check if product actually belongs to a restaurant
        if (!$product->category || !$product->category->restaurant) {
            return back()->withErrors(['message' => 'This product does not have a valid restaurant assigned.']);
        }

        $restaurant = $product->category->restaurant;

        $cart = session('cart', [
            'items'           => [],
            'total'           => 0,
            'restaurant_name' => '',
            'restaurant_id'   => '',
        ]);

        // Validation: Prevent mixing products from different restaurants
        $validator = Validator::make($cart, [
            'items.*.restaurant_id' => ['in:' . $restaurant->id],
        ], [
            'items.*.restaurant_id' => 'You can only order from one restaurant at a time.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['message' => 'Can\'t add product from different vendor.']);
        }

        $item = [
            'uuid'          => (string) str()->uuid(),
            'id'            => $product->id,
            'name'          => $product->name,
            'price'         => $product->price,
            'restaurant_id' => $restaurant->id,
        ];

        session()->push('cart.items', $item);
        session()->put('cart.restaurant_name', $restaurant->name);
        session()->put('cart.restaurant_id', $restaurant->id);

        $this->updateTotal();

        return back();
    }

    public function remove(string $uuid)
    {
        $items = collect(session('cart.items'))
            ->reject(fn ($item) => $item['uuid'] == $uuid);

        session(['cart.items' => $items->values()->toArray()]);
        $this->updateTotal();

        return back();
    }

    public function destroy()
    {
        session()->forget('cart');
        return back();
    }

    protected function updateTotal(): void
    {
        $items = collect(session('cart.items'));
        session()->put('cart.total', $items->sum('price'));
    }
}