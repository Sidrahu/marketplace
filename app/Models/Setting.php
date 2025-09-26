<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // Fillable fields
    protected $fillable = [
        'site_name',
        'site_email',
        'currency',
        'timezone',
    ];
}
