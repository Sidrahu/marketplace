<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
   protected $fillable = [
    'vendor_id',
    'user_id',
    'name',
    'description',
    'logo',
    'phone',
    'status',
    'email',
    'address',
    'currency',
    'opening_hours',
    'social_links',
];


public function user()
{
    return $this->belongsTo(User::class);
}

public function products()
    {
        return $this->hasMany(Product::class);
    }

}
