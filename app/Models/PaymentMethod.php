<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',          // Payment method name, e.g., GCASH
        'account_number',// The account number
        'account_name',  // The name of the account holder
        'display',        // Boolean to toggle display status
         'qr_code_image'
    ];
}
