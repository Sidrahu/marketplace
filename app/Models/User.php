<?php

namespace App\Models;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Shop;
use App\Models\ProductUser;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Invoice;
 
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'address',
        'profile_photo',
        'shop_name',
        'shop_description',
        'shop_logo',
        'shop_address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    
public function cartItems()
{
    return $this->hasMany(Cart::class, 'user_id');
}

public function shop()
{
    return $this->hasOne(Shop::class);
}

 

public function orders()
{
    return $this->hasMany(Order::class, 'user_id');
}
 


public function subscriptions()
{
    return $this->belongsToMany(Product::class, 'product_users')
                ->withTimestamps()
                ->withPivot(['subscribed_at', 'next_billing_date']);
}

public function carts()
{
    return $this->hasMany(Cart::class);
}

public function invoice(){
    return $this->hasMany(Invoice::class);
} 

public function invoices()
{
    return $this->hasMany(Invoice::class);
}


}
