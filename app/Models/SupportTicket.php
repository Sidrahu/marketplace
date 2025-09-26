<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    // Mass assignment allow karne ke liye
    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'status',
    ];

    // Agar chaho toh relationship bhi add kar sakte ho
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
