<?php 
namespace App\Http\Controllers\Staff;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(): Response
    {
        Gate::authorize('order.update');

        $restaurant_id = auth()->user()->restaurant_id;

        return Inertia::render('Staff/Orders', [
            'current_orders' => Order::current()
                ->with(['customer', 'products'])
                ->where('restaurant_id', $restaurant_id)
                ->latest()
                ->get(),
            'past_orders' => Order::past()
                ->with(['customer', 'products'])
                ->where('restaurant_id', $restaurant_id)
                ->latest()
                ->get(),
            'order_status' => OrderStatus::toArray(),
        ]);
    }

    public function update(UpdateOrderRequest $request, $orderId)
    {
        $order = Order::where('restaurant_id', $request->user()->restaurant_id)
            ->findOrFail($orderId);

        $order->update($request->validated());

        return back();
    }
}