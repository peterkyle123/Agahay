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
    public function statistics(Request $request) 
{
    $filter = $request->input('filter', 'total');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $categoryFilter = $request->input('category');
    $statusType = $request->input('status_type');

    $bookings = Booking::query();

    // Filter by status
    if ($statusType === 'done') {
        $bookings->where('status', 'Done');
    } elseif ($statusType === 'canceled') {
        $bookings->where('status', 'Canceled');
    }

    // Filter by date range
    if ($filter === 'date_range' && $startDate && $endDate) {
        $bookings->whereBetween('check_in_date', [$startDate, $endDate]);
    }

    // Filter by package
    if ($categoryFilter) {
        $bookings->where('package_name', $categoryFilter);
    }

    // Initialize both variables
    $revenuesByCategory = [];
    $initialPaymentsByCategory = [];

    // Calculate revenues by package for non-canceled bookings
    if ($filter !== 'canceled') {
        $revenuesByCategory = $bookings->get()->groupBy('package_name')->map(function ($bookings) {
            return $bookings->sum(function ($booking) {
                $numericPayment = preg_replace('/[^0-9.]/', '', $booking->payment);
                return is_numeric($numericPayment) ? floatval($numericPayment) : 0;
            });
        });
    }

    // Calculate initial payments by package for canceled bookings
    if ($filter === 'canceled') {
        $initialPaymentsByCategory = $bookings->get()->groupBy('package_name')->map(function ($bookings) {
            return $bookings->sum(function ($booking) {
                // Assuming there's an 'initial_payment' field for canceled bookings
                return $booking->initial_payment ?? 0;
            });
        });
    }

    // Return the data to the view
    return view('statistics', compact('revenuesByCategory', 'initialPaymentsByCategory', 'startDate', 'endDate', 'filter', 'categoryFilter'));
}

}