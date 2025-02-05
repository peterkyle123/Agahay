<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    // The attributes that are mass assignable
    protected $fillable = [
        'slug',       // Unique identifier for the package
        'name',       // Package name
        'description', // Package description
        'image',      // Package image
        'price',      // Price of the package (optional)
    ];

    // If you want to cast certain attributes (like dates or prices)
    protected $casts = [
        'price' => 'decimal:2',  // Example if you want to cast price as a decimal
    ];
}
