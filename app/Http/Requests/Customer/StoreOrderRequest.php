<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('order.create');
    }

    public function rules(): array
    {
        return [
            'restaurant_id' => ['required', 'exists:restaurants,id'],
            'total'         => ['required', 'integer', 'gt:0'],
            'items'         => ['required', 'array', 'min:1'],
            'items.*.name'  => ['required', 'string'],
            'items.*.price' => ['required', 'integer'],
        ];
    }

    protected function prepareForValidation()
    {
        $cart = session('cart');
        $this->merge([
            'restaurant_id' => $cart['restaurant_id'] ?? null,
            'items'         => $cart['items'] ?? [],
            'total'         => $cart['total'] ?? 0,
        ]);
    }
}