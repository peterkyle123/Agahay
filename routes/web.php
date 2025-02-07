<?php
use App\Models\Booking;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Admin;




// Admin login route
Route::post('/login1', function (Request $request) {
    // Validates the email and password input fields
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);
    // Looks up the admin by email
    $admin = Admin::where('email', $request->email)->first();

    // Checks if the admin exists and if the password matches
    if ($admin && Hash::check($request->password, $admin->password)) {
        session(['admin' => $admin->id]); // Store admin session
        return redirect()->route('dashboard'); // Redirects to dashboard after successful login
    }

    return back()->withErrors(['Invalid credentials']); // Returns an error if login fails
})->name('login1');

// Static routes for basic pages
Route::get('/', function () {
    return view('index'); // Home page view
});

Route::get('/book', function () {
    session()->flush(); 
    return view('book'); // Booking page view
})->name('book');

Route::get('/booking', function () {
    return view('booking'); // Booking form page view
})->name('booking');

Route::get('/adminlogin', function () {
    return view('adminlogin'); // Admin login page view
})->name('adminlogin');

// Dashboard route
Route::get('/dashboard', function () {
    if (!session()->has('admin')) {
        return redirect()->route('adminlogin'); // Redirects to login page if no session
    }
    $bookingCount = Booking::count();
    return view('dashboard', compact('bookingCount')); // Displays the dashboard with booking count
})->name('dashboard');

// Admin profile page route
Route::get('/adminprofile', function () {
    if (!session()->has('admin')) {
        return redirect()->route('adminlogin'); // Redirects to login page if no session
    }
    return view('adminprofile'); // Admin profile page view
})->name('adminprofile');

// Booking deletion route (DELETE request)
Route::delete('/admin/bookings', [BookingController::class, 'deleteBookings'])->name('admin.deleteBookings');

// Package routes
Route::get('/packages', [PackageController::class, 'show'])->name('packages');

// Booking-related routes
Route::get('/b00kings1', [BookingController::class, 'b00kings'])->name('b00kings1'); 
Route::post('/bookstore', [BookingController::class, 'bookstore'])->name('bookstore'); 
Route::post('/bookform', [BookingController::class, 'store'])->name('bookform.store');

// Static pages routes
Route::get('/aboutus', function () {
    return view('aboutus'); // About us page view
})->name('aboutus');

Route::get('/gallerysection', function () {
    return view('gallerysection'); // Gallery section page view
})->name('gallerysection');

Route::get('/trackbooking', function () {
    return view('trackbooking'); // Track booking page view
})->name('trackbooking');

// Booking page route
Route::get('/b00kings', function () {
    return view('b00kings'); // Displays bookings
})->name('b00kings');

// Admin logout page route
Route::get('/adminlogout', function () {
    return view('adminlogout'); // Admin logout page view
})->name('adminlogout');

// Admin home page route
Route::get('/adminhome', function () {
    return view('adminhome'); // Admin home page view
})->name('adminhome');

// Admin logout and session invalidate route
Route::get('/adminhome12', function () {
    Auth::logout(); 
    session()->invalidate(); 
    session()->regenerateToken(); 
    return redirect()->route('adminhome');
});

// Route to display booking data by tracking code
Route::post('/trackbooking', [BookingController::class, 'trackBooking'])->name('trackbooking');

Route::post('/cancel-booking/{bookingId}', [BookingController::class, 'cancel'])->name('booking.cancel');

// ** New Route to Update Booking Status to "Done" **
Route::patch('/admin/bookings/update-status', [AdminController::class, 'updateBookingsStatus'])->name('admin.updateBookingsStatus');
