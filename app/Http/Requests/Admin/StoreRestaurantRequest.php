<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
 public function authorize(): bool
{
    return \Illuminate\Support\Facades\Gate::allows('restaurant.create');
}

public function rules(): array
{
    return [
        'restaurant_name' => ['required', 'string', 'max:255'],
        'email'           => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'owner_name'      => ['required', 'string', 'max:255'],
        'city_id'         => ['required', 'exists:cities,id'],
        'address'         => ['required', 'string'],
    ];
}
}
