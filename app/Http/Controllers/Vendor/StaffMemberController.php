<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\StoreStaffMemberRequest;
use App\Models\Role;
use App\Models\User;
use App\Notifications\RestaurantStaffInvitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate; // Added this import
use Inertia\Inertia;
use Inertia\Response;

class StaffMemberController extends Controller
{
    public function index(): Response
    {
        // Changed to Gate to avoid the "Call to undefined method" error
        Gate::authorize('user.viewAny');

        return Inertia::render('Vendor/Staff/Show', [
            'staff' => auth()->user()->restaurant->staff()->get(),
        ]);
    }

    public function store(StoreStaffMemberRequest $request): RedirectResponse
    {
        $restaurant = $request->user()->restaurant;
        $attributes = $request->validated();

        $member = DB::transaction(function () use ($attributes, $restaurant) {
            $user = $restaurant->staff()->create([
                'name'     => $attributes['name'],
                'email'    => $attributes['email'],
                'password' => '', // Empty password for invitation flow
            ]);

            $user->roles()->sync(Role::where('name', RoleName::STAFF->value)->first());

            return $user;
        });

        $member->notify(new RestaurantStaffInvitation($restaurant->name));

        return back();
    }

    public function destroy(User $staffMember): RedirectResponse
    {
        // Changed to Gate here as well
        Gate::authorize('user.delete');

        // Security check: ensure staff belongs to the vendor's restaurant
        if ($staffMember->restaurant_id !== auth()->user()->restaurant_id) {
            abort(403);
        }

        $staffMember->roles()->detach();
        $staffMember->delete();

        return back()->with('status', 'Staff member removed successfully.');
    }
}