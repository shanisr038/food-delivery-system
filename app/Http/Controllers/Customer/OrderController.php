<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreOrderRequest;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        Gate::authorize('order.viewAny');

        return Inertia::render('Customer/Orders', [
            'orders' => auth()->user()->orders()
                ->with(['restaurant', 'products'])
                ->latest()
                ->get()
        ]);
    }

    public function store(StoreOrderRequest $request)
    {
        $cart = session('cart');

        if (!$cart) {
            return back()->withErrors(['message' => 'Your cart is empty.']);
        }

        $order = DB::transaction(function () use ($cart) {
            $order = auth()->user()->orders()->create([
                'restaurant_id' => $cart['restaurant_id'],
                'total'         => $cart['total'],
                'status'        => OrderStatus::PENDING,
            ]);

            // Save name, price, AND quantity for each item
            $items = collect($cart['items'])->map(function($item) {
                return [
                    'name'     => $item['name'],
                    'price'    => $item['price'],
                    'quantity' => $item['quantity'] ?? 1, // Added this
                ];
            })->toArray();

            $order->products()->createMany($items);
            
            return $order;
        });

        $order->load(['customer', 'restaurant.owner', 'products']);

        if ($order->restaurant && $order->restaurant->owner) {
            $order->restaurant->owner->notify(new \App\Notifications\NewOrderCreated($order));
        }

        session()->forget('cart');

        return to_route('customer.orders.index')->with('status', 'Order placed!');
    }
}