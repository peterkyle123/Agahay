<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
        // ... other methods ...
    
        public function totalRevenues()
        {
            $bookings = Booking::where('status', 'Done')->get();
            $totalRevenues = 0;
    
            foreach ($bookings as $booking) {
                // Remove any non-numeric characters (e.g., currency symbols)
                $numericPayment = preg_replace('/[^0-9.]/', '', $booking->payment);
    
                // Convert the cleaned string to a float or decimal
                $paymentValue = floatval($numericPayment);
    
                $totalRevenues += $paymentValue;
            }
    
            return view('total_revenues', compact('totalRevenues'));
        }
}
     



