<?php

namespace App\Http\Controllers;
use App\Models\Booking;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    
    public function deleteBookings(Request $request)
    {
        $bookingIds = $request->input('bookings'); // Array of selected booking IDs
    
        if ($bookingIds) {
            // Delete selected bookings
            Booking::whereIn('id', $bookingIds)->delete();
    
            return redirect()->back()->with('success', 'SUCCESFULLY DELETED');
        }
    
        return redirect()->back()->with('error', 'error');
    }  
    //
    public function index()
    {
       
       
        $bookings = Booking::all();
        return view('admin.bookings', compact('bookings'));
    }
    public function b00kings()
    {
       
        $bookings = Booking::all();

        // Return the view with the bookings data
        return view('b00kings', compact('bookings'));
    }
    public function bookstore()
    {
        // Return the view with the bookings data
        return view('booking');
    }
    
        public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'phone' => 'required|digits:11',
            'extra_pax' => 'nullable|integer|min:0',
            'special_request' => 'nullable|string|max:500',
        ]);

        $trackingCode = 'BK' . strtoupper(Str::random(1)) . '-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT) . '-' . strtoupper(Str::random(1));

        // Save to database
        Booking::create([
            'customer_name' => $request->customer_name,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'phone' => $request->phone,
            'extra_pax' => $request->extra_pax,
            'special_request' => $request->special_request,
         'tracking_code' => $trackingCode, // Save the generated tracking code
        ]);
   
        session(['tracking_code' => $trackingCode]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Booking submitted successfully!');
    }
    public function trackBooking(Request $request)
{
    // Validate the input
    $request->validate([
        'tracking_code' => 'required|string',
    ]);

    // Find the booking by the tracking code
    $booking = Booking::where('tracking_code', $request->tracking_code)->first();

    if ($booking) {
        // If a booking is found, return it to the view
        return view('trackbooking', compact('booking'));
    } else {
        // If no booking is found, return with an error
        return back()->withErrors(['tracking_code' => 'No booking found for this tracking code.']);
    }
}
public function showBookingPage()
{
    // Generate a new tracking code
    $trackingCode = 'BK' . strtoupper(Str::random(3)) . '-' . rand(1000, 9999); // New tracking code (4-digit number)

    // Pass the tracking code to the view
    return view('trackbooking', compact('trackingCode'));
}
public function cancel($bookingId)
{
    // Find the booking by ID
    $booking = Booking::find($bookingId);

    if ($booking) {
        // Update the booking status to "Canceled"
        $booking->status = 'Canceled';
        $booking->save();

        // Redirect with success message
        return redirect()->route('booking.show', $bookingId)->with('success', 'Your booking has been canceled.');
    }

    return redirect()->back()->with('error', 'Booking not found.');
}

}

