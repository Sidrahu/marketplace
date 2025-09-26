<?php

namespace App\Models;
use App\Models\Shop;
use App\Models\ProductImage;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['shop_id','name','description','quantity','price','status' ,'vendor_id'];

public function shop()
{
    return $this->belongsTo(Shop::class);
}

public function images()
{
    return $this->hasMany(ProductImage::class);
}
 
public function subscribers()
{
    return $this->belongsToMany(User::class, 'product_users')
                ->withTimestamps()
                ->withPivot(['subscribed_at', 'next_billing_date']);
}


public function vendor()
{
    return $this->belongsTo(User::class, 'vendor_id');
}
 
public function user()
{
    return $this->belongsTo(User::class);
}


public function carts()
{
    return $this->hasMany(Cart::class);
}
 public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

}
