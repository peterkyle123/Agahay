<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class RevenueController extends Controller
{
    public function totalRevenues(Request $request)
    {
        $filter = $request->input('filter', 'total');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $packageName = $request->input('package_name');

        $bookings = Booking::where('status', 'Done');

        if ($packageName) {
            $bookings->where('package_name', $packageName);
        }

        if ($filter === 'date_range' && $startDate && $endDate) {
            $bookings->whereBetween('check_in_date', [$startDate, $endDate]);
        }

        $bookingsForTable = $bookings->get();

        $filteredRevenues = $bookingsForTable->sum(function ($booking) {
            $numericPayment = preg_replace('/[^0-9.]/', '', $booking->payment);
            return is_numeric($numericPayment) ? floatval($numericPayment) : 0;
        });

        $packages = Booking::distinct()->pluck('package_name'); // Get distinct package names

        return view('total_revenues', compact('filteredRevenues', 'startDate', 'endDate', 'bookingsForTable', 'packages'));
    }
}