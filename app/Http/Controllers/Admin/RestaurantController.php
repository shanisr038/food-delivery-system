<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\UpdateRestaurantRequest;
use Illuminate\Http\RedirectResponse;

use App\Http\Requests\Admin\StoreRestaurantRequest;
use App\Models\City;
use App\Models\User;
use App\Models\Role;
use App\Enums\RoleName;
use Illuminate\Support\Facades\DB;
use App\Notifications\RestaurantOwnerInvitation;

class RestaurantController extends Controller
{
    public function index(): Response
    {
        Gate::authorize('restaurant.viewAny');

        return Inertia::render('Admin/Restaurants/Index', [
            'restaurants' => Restaurant::with(['city', 'owner'])->get(),
        ]);
    }
    public function create()
{
    Gate::authorize('restaurant.create');

    return inertia('Admin/Restaurants/Create', [
        'cities' => City::all(['id', 'name']),
    ]);
}

public function store(StoreRestaurantRequest $request)
{
    $validated = $request->validated();

    DB::transaction(function () use ($validated) {
        $user = User::create([
            'name'     => $validated['owner_name'],
            'email'    => $validated['email'],
            'password' => bcrypt(str()->random(10)), // Generate a random temp password
        ]);

        $user->roles()->sync(Role::where('name', RoleName::VENDOR->value)->first());

        $user->restaurant()->create([
            'city_id' => $validated['city_id'],
            'name'    => $validated['restaurant_name'],
            'address' => $validated['address'],
        ]);

        $user->notify(new RestaurantOwnerInvitation($validated['restaurant_name']));
    });

    return to_route('admin.restaurants.index');
}
public function edit(Restaurant $restaurant)
{
    Gate::authorize('restaurant.update');

    // We load the owner so we can show the email in the form
    $restaurant->load(['city', 'owner']);

    return inertia('Admin/Restaurants/Edit', [
        'restaurant' => $restaurant,
        'cities'     => City::all(['id', 'name']),
    ]);
}

public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
{
    $validated = $request->validated();

    $restaurant->update([
        'city_id' => $validated['city'],
        'name'    => $validated['restaurant_name'],
        'address' => $validated['address'],
    ]);

    return to_route('admin.restaurants.index')
        ->with('status', 'Restaurant updated successfully.');
}
public function destroy(Restaurant $restaurant): RedirectResponse
{

    Gate::authorize('restaurant.delete');

    $restaurant->delete();

    return back()->with('status', 'Restaurant deleted successfully.');
}
}