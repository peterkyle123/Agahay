<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'check_in_date',
        'check_out_date',
        'status',
        'package_name',
        'phone',
        'payment',
        'extra_pax',        // Add this
        'special_request',
        'tracking_code',  
        // Add this
    ];
}

