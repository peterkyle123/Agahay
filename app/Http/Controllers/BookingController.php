<?php

namespace App\Http\Controllers;
use App\Models\Booking;

use Illuminate\Http\Request;

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
    // public function store(Request $request)
    // {
    //     // Validate input
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'nullable|email',
    //         'phone' => 'required|digits:11',
    //         'checkin' => 'required|date',
    //         'checkout' => 'required|date|after_or_equal:checkin',
    //         'extra_pax' => 'required|integer|min:0',
    //         'special_requests' => 'nullable|string',
    //     ]);

    //     // Insert into database
    //     Booking::create($request->all());

    //     return redirect()->back()->with('success', 'Booking submitted successfully!');
    // }
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

        // Save to database
        Booking::create([
            'customer_name' => $request->customer_name,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'phone' => $request->phone,
            'extra_pax' => $request->extra_pax,
            'special_request' => $request->special_request,
        ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Booking submitted successfully!');
    }
}

