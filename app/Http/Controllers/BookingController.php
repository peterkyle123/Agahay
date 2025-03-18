<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DateTime;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Log;


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


    $bookings = Booking::whereIn('status', ['Pending', 'Done'])->get();

        // Sort by check-in date, newest first
    $bookings = $bookings->sortByDesc('check_in_date'); // Key change

 // Calculate "Number of Days Staying" for each booking
 foreach ($bookings as $booking) {
    $checkInDate = Carbon::parse($booking->check_in_date);
    $checkOutDate = Carbon::parse($booking->check_out_date);

    $booking->days_staying = $checkInDate->diffInDays($checkOutDate); // Calculate the difference in days
    // $booking->save(); // Add this line
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
    $package = Package::where('package_name', $request->package_name)->first();
    $packageDays = $package ? $package->number_of_days : 1;

        // Build a conditional rule for check_out_date:
    // For 1-day packages, allow same-day checkout (after_or_equal);
    // for packages > 1 day, require checkout to be after check-in.
    $checkOutRule = $packageDays > 1 ? 'after:check_in_date' : 'after_or_equal:check_in_date';
    // Validate input
    $request->validate([
        'customer_name' => 'required|string|max:255',
        'guest_name' => 'nullable|string|max:255',
        'check_in_date' => 'required|date',
        'check_out_date' => 'required|date|' . $checkOutRule,
        'phone' => 'required|digits:11',
        'extra_pax' => 'nullable|integer|min:0',
        'package_name' => 'nullable|string|max:255',
        'payment'          => 'required|numeric',  // Original total payment
        'discount'         => 'nullable|numeric|min:0', // Optional discount
        'special_request' => 'nullable|string|max:500',
        'proof_of_payment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:3000', // Max 2MB
    ]);

    // Default discount to 0 if not provided.
    $discount = $request->discount ?? 0;

    $checkInDate = $request->check_in_date;
    $checkOutDate = $request->check_out_date;
    // Retrieve package to get its check in/out times (assumes package_name is provided)
    $package = Package::where('package_name', $request->package_name)->first();
    if ($package) {
        $checkInTime = $package->check_in_time;
        $checkOutTime = $package->check_out_time;
        $packageDays = $package->number_of_days;
    } else {
        // Set as null or default values if package not found
        $checkInTime = null;
        $checkOutTime = null;
        $packageDays = 1; // Default to 1 if package not found
    }

    // If package requires more than 1 day, then check that check_out_date is strictly after check_in_date.
    if ($packageDays > 1 && $checkInDate == $checkOutDate) {
        return redirect()->back()->with('error1', 'For this package, the check-out date must be after the check-in date.');
    }

    // Check if dates are available (excluding "Canceled" bookings)
    $overlappingBookings = Booking::whereNotIn('status', ['Canceled', 'Declined'])
        ->where(function ($query) use ($checkInDate, $checkOutDate) {
            $query->where('check_in_date', '<', $checkOutDate)
                ->where('check_out_date', '>', $checkInDate);
        })->exists();
        if ($overlappingBookings) {
            return redirect()->back()->with('error1', 'These dates are already booked. Please choose different dates.');
        }
     // Handle proof of payment upload
     if ($request->hasFile('proof_of_payment')) {
        $file = $request->file('proof_of_payment');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads/downpayments', $fileName, 'public'); // Save to storage/app/public/uploads/downpayments
    } else {
        return redirect()->back()->with('error', 'Proof of downpayment is required.');
    }
    // Generate a unique tracking code
    $trackingCode = 'BK' . strtoupper(Str::random(1)) . '-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT) . '-' . strtoupper(Str::random(1));

    // Save to database
    Booking::create([
        'customer_name' => $request->customer_name,
        'guest_name' => $request->guest_name, // Save guest name
        'check_in_date' => $checkInDate,
        'check_out_date' => $checkOutDate,
        'check_in_time'   => $checkInTime,    // Added field
        'check_out_time'  => $checkOutTime,   // Added field
        'phone' => $request->phone,
        'extra_pax' => $request->extra_pax,
        'special_request' => $request->special_request,
        'package_name' => $request->package_name,
         // Convert payment to float and format as needed; stored as string but cast in model.
        'payment'          => number_format((float)$request->payment, 2, '.', ''),
        'discount'         => $discount,
        'tracking_code' => $trackingCode,
        'proof_of_payment' => $filePath, // Save file path in database
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
        // Update the booking status to "Request for Cancellation"
        $booking->status = 'Request for Cancellation';
        $booking->save();

        // Return a JSON success response
        return response()->json(['success' => 'Cancellation request submitted.']);
    }

    // Return a JSON error response
    return response()->json(['error' => 'Booking not found.']);
}
public function canceledBookings()
{
    if (!session()->has('admin')) {
        return redirect()->route('adminlogin'); // Redirects to login page if no session
    }
    $canceledBookings = Booking::where('status', 'Request for Cancellation')->get();
    return view('cancelrequestA', ['canceledBookings' => $canceledBookings]); // Fix the variable name
}


public function showPackages() {

    $packages = Package::all(); // Retrieve all available packages
    return view('book', compact('packages'));

}

public function showForm($package_id) {

    $packages = Package::findOrFail($package_id);
    $paymentMethods = PaymentMethod::where('display', true)->get();
    return view('booking', compact('packages', 'paymentMethods'));

}
public function showBookings(Request $request)
{
    $search = $request->input('search');
    $sortOrder = $request->input('sort', 'asc'); // Default to ascending
    $bookingsQuery = Booking::query();

        // Filter bookings with status "Pending"
        $bookingsQuery->where('status', 'Pending');

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

    if (!session()->has('admin')) {
        return redirect()->route('adminlogin'); // Redirects to login page if no session
    }
    $packages = Package::where('package_id', $id)->first(); // Fetch a single package

    if (!$packages) {
        return abort(404); // Return a 404 error if package not found
    }

    return view('editpackages', compact('packages')); // Pass single package to the view
}
public function calendar(Request $request)
{
    if (!session()->has('admin') && !$request->has('userView')) {
        return redirect()->route('adminlogin');
    }

    $bookings = Booking::all()->map(function ($booking) use ($request) {
        $event = [
            'start' => $booking->check_in_date,
            'end' => Carbon::parse($booking->check_out_date)->addDay()->toDateString(),
            'extendedProps' => [
                'status' => $booking->status,
            ],
        ];

        if (!$request->has('userView')) {
            $event['title'] = $booking->customer_name . ' - ' . $booking->package_name;
        }

        return $event;
    }); // Corrected: Closure ends here

    if ($request->has('userView')) {
        return view('user_calendar', compact('bookings'));
    } else {
        return view('calendar', compact('bookings'));
    }
}
public function approveBooking($id)
    {

        $booking = Booking::find($id);

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found.');
        }

        $booking->status = 'Canceled'; // Change status to Canceled
        $booking->save();

        return redirect()->back()->with('success', 'Booking has been canceled successfully.');
    }

    public function showApprovedBookings()
    {
        if (!session()->has('admin')) {
            return redirect()->route('adminlogin'); // Redirects to login page if no session
        }

        $approvedCanceledBookings = Booking::where('status', 'Canceled')->get();

        return view('approvedCanceled', compact('approvedCanceledBookings'));
    }


    public function RejectBooking($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found.');
        }

        $booking->status = 'Pending'; // Change status to Canceled
        $booking->save();

        return redirect()->back()->with('success', 'Booking has been canceled successfully.');
    }
    public function getUnavailableDates()
{
    // Get all booked check-in and check-out dates where status is NOT "Canceled"
       $unavailableBookings = Booking::whereNotIn('status', ['Canceled', 'Declined'])
        ->get(['check_in_date', 'check_out_date']);

    $unavailableDates = [];

    // Loop through bookings and add booked dates to the unavailable list
    foreach ($unavailableBookings as $booking) {
        $checkIn = new DateTime($booking->check_in_date);
        $checkOut = new DateTime($booking->check_out_date);

        while ($checkIn <= $checkOut) {
            $unavailableDates[] = $checkIn->format('Y-m-d');
            $checkIn->modify('+1 day');
        }
    }

    return response()->json(['unavailable_dates' => $unavailableDates]);
}

public function calendars(Request $request)
{

    $bookings = Booking::all()->map(function ($booking) use ($request) {
        $event = [
            'start' => $booking->check_in_date,
            'end' => Carbon::parse($booking->check_out_date)->addDay()->toDateString(),
            'extendedProps' => [
                'status' => $booking->status,
            ],
        ];

        if (!$request->has('userView')) {
            $event['title'] = $booking->package_name;
        }

        return $event;
    }); // Corrected: Closure ends here

    if ($request->has('userView')) {
        return view('user_calendar', compact('bookings'));
    } else {
        return view('user_calendar', compact('bookings'));
    }
}
public function lockDownpayment(Request $request, $bookingId)
{
    $booking = Booking::find($bookingId);

    if (!$booking) {
        return response()->json(['error' => 'Booking not found'], 404);
    }

    $downpaymentStatus = $request->input('downpayment');

    $booking->downpayment = $downpaymentStatus;
    $booking->downpayment_locked = true;

    $booking->save(); // The model's boot() method will calculate the balance

    return response()->json(['success' => 'Downpayment status updated']);
}

public function uploadProofOfPayment(Request $request, Booking $booking)
{
    $request->validate([
        'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($request->hasFile('proof_of_payment')) {
        $file = $request->file('proof_of_payment');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('proofs', $filename, 'public'); // Store in storage/app/public/proofs

        // Update the booking's proof_of_payment field
        $booking->proof_of_payment = 'proofs/' . $filename;
        $booking->save();

        return response()->json(['success' => 'Proof of payment uploaded successfully.']);
    }

    return response()->json(['error' => 'Failed to upload proof of payment.']);
}

public function showEditUser($id)
{
    $booking = Booking::findOrFail($id);
    return view('editbooking', compact('booking'));
}

public function updateUser(Request $request, $id)
{
    $booking = Booking::findOrFail($id);

    $validatedData = $request->validate([
        'customer_name'   => 'required|string|max:255',
        'check_in_date'   => 'required|date',
        'check_out_date'  => 'required|date|after:check_in_date',
        'phone'           => 'required|digits:11',
        'extra_pax'       => 'required|integer|min:0',
        'special_request' => 'nullable|string',
        'payment'         => 'required|numeric|min:0'
    ]);

    // Update only the base booking details and base payment
    $booking->customer_name   = $validatedData['customer_name'];
    $booking->check_in_date   = $validatedData['check_in_date'];
    $booking->check_out_date  = $validatedData['check_out_date'];
    $booking->phone           = $validatedData['phone'];
    $booking->extra_pax       = $validatedData['extra_pax'];
    $booking->special_request = $validatedData['special_request'];
    $booking->payment         = $validatedData['payment'];

    $booking->save();
    $booking->refresh();

    return redirect()->route('trackbooking')->with('success', 'Booking updated successfully!');
}



public function deleteMultiple(Request $request) {
    $bookingIds = $request->bookingIds;
    Booking::whereIn('id', $bookingIds)->delete();
    return response()->json(['success' => true]);
}
public function filterBookings($status)
{
    $bookings = Booking::where('status', $status)->paginate(5);

    return view('bookings_table', compact('bookings'));
}

public function showFilteredBookings()
{
    $bookings = Booking::paginate(5);
    return view('filter_bookings', compact('bookings'));
}
// added
public function updateBookingsStatus(Request $request, $id)
{
    // Validate the submitted discount and final_payment arrays.
    $validatedData = $request->validate([
        'discount.*' => 'required|numeric|min:0|max:100',
        'final_payment.*' => 'required|numeric|min:0'
    ]);

    // Extract the discount and final payment for the booking being approved
    $discounts = $request->input('discount');       // e.g., ['123' => 10, ...]
    $final_payments = $request->input('final_payment'); // e.g., ['123' => 9000.00, ...]

    if (!isset($discounts[$id]) || !isset($final_payments[$id])) {
        return redirect()->back()->with('error', 'Invalid data submitted for the booking.');
    }

    $discount = $discounts[$id];
    $final_payment = $final_payments[$id];

    $booking = Booking::findOrFail($id);

    // Update discount and overwrite payment with the new final payment value.
    $booking->discount = $discount;
    $booking->payment = number_format($final_payment, 2, '.', '');
    $booking->status = 'Approved';  // Optionally mark as Approved
    $booking->save();

    return redirect()->back()->with('success', 'Booking updated and discount applied successfully!');
}



}
