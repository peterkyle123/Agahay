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
        // Filter out only bookings that are 'Done' or 'Canceled' (Prevent 'Pending' from deletion)
        $deleted = Booking::whereIn('id', $bookingIds)
            ->whereIn('status', ['Canceled'])
            ->delete();
    
        if ($deleted) {
            return redirect()->back()->with('success', 'Successfully deleted Canceled bookings.');
        } else {
            return redirect()->back()->with('error', 'Pending and Done bookings cannot be deleted.');
        }
    }
    
    return redirect()->back()->with('error', 'No valid bookings selected for deletion.');
    
}

    //
    public function index()
    {
       
       
        $bookings = Booking::all();
        return view('admin.bookings', compact('bookings'));
    }
    public function b00kings( )
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
            'total_payment'=>'nullable|string|max:500',
            'special_request' => 'nullable|string|max:500',
        ]);

        $checkInDate = $request->check_in_date;
    $checkOutDate = $request->check_out_date;

    // Check for overlapping bookings
    $overlappingBookings = Booking::where(function ($query) use ($checkInDate, $checkOutDate) {
        $query->where('check_in_date', '<', $checkOutDate)
            ->where('check_out_date', '>', $checkInDate);
    })->exists();

    if ($overlappingBookings) {
        return redirect()->back()->with('error1', 'These dates are already booked. Please choose different dates.');
    }

    $trackingCode = 'BK' . strtoupper(Str::random(1)) . '-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT) . '-' . strtoupper(Str::random(1));

    // Save to database
    Booking::create([
        'customer_name' => $request->customer_name,
        'check_in_date' => $checkInDate,
        'check_out_date' => $checkOutDate,
        'phone' => $request->phone,
        'extra_pax' => $request->extra_pax,
        'special_request' => $request->special_request,
        'package_name' => $request->package_name,
        'payment' => $request->total_payment,
        'tracking_code' => $trackingCode,
    ]);

    session(['tracking_code' => $trackingCode]);

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
public function showBookings(Request $request)
{
    $search = $request->input('search');
    $sortOrder = $request->input('sort', 'asc'); // Default to ascending
    $bookingsQuery = Booking::query();

    // Fetch the bookings based on the query
    $bookings = $bookingsQuery->orderBy('check_in_date', $sortOrder)->get();
    $bookings = $bookingsQuery->get(); // Get the bookings BEFORE the foreach loop

    if ($search) {
        foreach ($bookings as $booking) {
            if (
                Str::contains($booking->tracking_code, $search, true) ||
                Str::contains($booking->customer_name, $search, true) ||
                Str::contains($booking->check_in_date, $search, true)
            ) {
                $booking->highlight = true; // Add highlight property if search matches
            } else {
                $booking->highlight = false; // Add highlight property, set to false if it does not match.
            }
        }
    } else {
        foreach($bookings as $booking){
            $booking->highlight = false;
        }
    }

    $canceledBookingsCount = Booking::where('status', 'Canceled')->count();
    
    foreach ($bookings as $booking) {
        $checkInDate = Carbon::parse($booking->check_in_date);
        $checkOutDate = Carbon::parse($booking->check_out_date);
        $booking->days_staying = $checkInDate->diffInDays($checkOutDate);
    }

    return view('b00kings', compact('bookings', 'canceledBookingsCount'));
}
public function edit($id) {

    
    $packages = Package::where('package_id', $id)->first(); // Fetch a single package
    
    if (!$packages) {
        return abort(404); // Return a 404 error if package not found
    }

    return view('editpackages', compact('packages')); // Pass single package to the view
}

}

