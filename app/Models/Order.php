<?php

namespace App\Models;
use App\Models\User;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Cart;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'buyer_id','amount', 'user_id','vendor_id', 'product_id','invoice_id', 'status', 'quantity', 'total_price',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

   
public function invoice()
{
    return $this->hasOne(Invoice::class, 'order_id');
}

 

public function cartItems()
{
    return $this->hasMany(Cart::class, 'user_id');
}


}
