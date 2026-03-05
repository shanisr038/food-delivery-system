<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password','restaurant_id'];

    protected $hidden = ['password', 'remember_token'];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    // This is the function called by HandleInertiaRequests
    public function permissions(): array
    {
        return $this->roles()->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->unique()
            ->values()
            ->toArray();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
    
    public function restaurant(): \Illuminate\Database\Eloquent\Relations\HasOne
{
    return $this->hasOne(Restaurant::class, 'owner_id');
}
    public function hasPermission(string $permission): bool
{
    return $this->roles()->whereHas('permissions', function ($query) use ($permission) {
        $query->where('name', $permission);
    })->exists();
}
}