<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function showBookingForm($customerId)
    {
        // Fetch customer data from the database
        $customer = Customer::find($customerId); // Adjust based on your model
        return view('booking.create', compact('customer'));
    }
}
