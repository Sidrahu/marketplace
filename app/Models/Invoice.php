<?php

namespace App\Models;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

  
    protected $fillable = [
    'user_id',
    'invoice_number',
    'amount',
    'order_id',
    'status',
    'details',
    'path',  
];


    protected $casts = [
        'details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   // Invoice.php
public function order()
{
    return $this->belongsTo(Order::class);
}


    // Unique invoice number generate karne ke liye helper method
    public static function generateInvoiceNumber()
    {
        return 'INV-' . strtoupper(uniqid());
    }
}
