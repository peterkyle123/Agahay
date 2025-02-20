<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class RevenueController extends Controller
{
        // ... other methods ...
    
    
            public function totalRevenues(Request $request)
            {
                $filter = $request->input('filter', 'total');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $bookings = Booking::where('status', 'Done');

        $filteredRevenues = null;
        $bookingsForTable = null;

        if ($filter === 'date_range' && $startDate && $endDate) {
            // Filter by check_in_date instead of created_at
            $bookings->whereBetween('check_in_date', [$startDate, $endDate]);
            $bookingsForTable = $bookings->get();
            $filteredRevenues = 0;
            foreach ($bookingsForTable as $booking) {
                $numericPayment = preg_replace('/[^0-9.]/', '', $booking->payment);
                if (is_numeric($numericPayment)) {
                    $paymentValue = floatval($numericPayment);
                    $filteredRevenues += $paymentValue;
                }
            }
        } else {
            $bookingsForTable = $bookings->get();
            $filteredRevenues = 0;
            foreach ($bookingsForTable as $booking) {
                $numericPayment = preg_replace('/[^0-9.]/', '', $booking->payment);
                if (is_numeric($numericPayment)) {
                    $paymentValue = floatval($numericPayment);
                    $filteredRevenues += $paymentValue;
                }
            }
        }

        return view('total_revenues', compact('filteredRevenues', 'startDate', 'endDate', 'bookingsForTable'));
    }
}
     



