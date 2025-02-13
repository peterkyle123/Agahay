<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Package;
use Carbon\Carbon; 
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
           if (!session()->has('admin')) {
        return redirect()->route('adminlogin'); // Redirects to login page if no session
    }

    
        $bookings = Booking::all();
        // Sort by check-in date, newest first
    $bookings = $bookings->sortByDesc('check_in_date'); // Key change

 // Calculate "Number of Days Staying" for each booking
 foreach ($bookings as $booking) {
    $checkInDate = Carbon::parse($booking->check_in_date);
    $checkOutDate = Carbon::parse($booking->check_out_date);

    $booking->days_staying = $checkInDate->diffInDays($checkOutDate); // Calculate the difference in days

}
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
'package_name' => 'nullable|string|max:255',
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
            'package_name' => $request->package_name,
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

    if ($booking) { // Check if a booking EXISTS first
        if ($booking->status == "Canceled" || $booking->status == "Done") {
            return back()->withErrors(['tracking_code' => 'Booking is ' . strtolower($booking->status) . '.']); // More informative message
        } else {
            return view('trackbooking', compact('booking')); // Booking found and not canceled/done
        }
    } else {
        return back()->withErrors(['tracking_code' => 'No booking found for this tracking code.']); // No booking at all
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
public function showPackages() {
    $packages = Package::all(); // Retrieve all available packages
    return view('book', compact('packages'));
}

public function showForm($package_id) {
    $packages = Package::findOrFail($package_id);
    return view('booking', compact('packages'));
}
public function showBookings()
{
    // Fetch all bookings
    $bookings = Booking::all(); 

    // Fetch only the count of canceled bookings
    $canceledBookingsCount = Booking::where('status', 'Canceled')->count(); 

    // Debug to check if the variable is set
    if($canceledBookingsCount); // This will stop execution and show the value

    return view('admin.bookings', [
        'bookings' => $bookings,
        'canceledBookingsCount' => $canceledBookingsCount
    ]);
     // Calculate "Number of Days Staying" for each booking
     foreach ($bookings as $booking) {
        $checkInDate = Carbon::parse($booking->check_in_date);
        $checkOutDate = Carbon::parse($booking->check_out_date);

        $booking->days_staying = $checkOutDate->diffInDays($checkInDate); // Calculate the difference in days

    }

    return view('b00kings', compact('bookings'));
}

}

