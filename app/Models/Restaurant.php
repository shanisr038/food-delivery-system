<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Restaurant extends Model
{
    use HasFactory;
    protected $fillable = ['city_id', 'owner_id', 'name', 'address'];

    public function owner()
{
   
    return $this->belongsTo(User::class, 'owner_id');
}

public function city()
{
    return $this->belongsTo(City::class);
}
public function categories()
{
    return $this->hasMany(Category::class);
}
public function staff(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(User::class);
}
protected static function booted()
{
    static::deleting(function ($restaurant) {
        
        if ($restaurant->logo) {
            Storage::disk('public')->delete($restaurant->logo);
        }
    });
}
}
