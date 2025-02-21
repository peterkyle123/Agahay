<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages'; // Ensure Laravel uses the correct table

    protected $primaryKey = 'package_id'; // Set the correct primary key

    public $incrementing = false; // If `package_id` is NOT an auto-incrementing integer

    public $timestamps = false; // Disable timestamps

    protected $keyType = 'string'; // Use 'integer' if it's a numeric ID

    protected $fillable = [
        'package_id',  // Ensure your primary key is included
        'slug',
        'package_name',
        'description',
        'image',
        'price',
        'initial_payment',
        'number_of_guests', 
        'fri_sun_price',
        'available', 
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'available' => 'boolean', //optional but recommended
    ];
}

