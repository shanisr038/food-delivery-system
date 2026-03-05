<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use App\Enums\RoleName;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'restaurant_id' => null,
        ];
    }

    public function vendor(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->roles()->sync(Role::where('name', RoleName::VENDOR->value)->first());
        });
    }

    public function staff(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->roles()->sync(Role::where('name', RoleName::STAFF->value)->first());
        });
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}