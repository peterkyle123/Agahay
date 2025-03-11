<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'guest_name',
        'check_in_date',
        'check_out_date',
        'days_staying',
        'status',
        'package_name',
        'phone',
        'payment',
        'discount', // Added discount field
        'extra_pax',        // Add this
        'special_request',
        'cancellation_requested',
        'tracking_code',
        'proof_of_payment',
        'decline_reason'

        // Add this
    ];

    // Cast payment and discount to float
    protected $casts = [
        'payment'  => 'float',
        'discount' => 'float',
    ];

    /**
     * Computed attribute to get final payment after discount.
     *
     * @return float
     */
    public function getFinalPaymentAttribute()
    {
        return max(0, $this->payment - $this->discount);
    }
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_name', 'package_name');
    }

}
