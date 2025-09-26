<?php
namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductUser extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'next_billing_date',
        'subscribed_at',
        'status'
    ];

    // Use casts to convert to Carbon instances
    protected $casts = [
        'subscribed_at' => 'datetime',
        'next_billing_date' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
