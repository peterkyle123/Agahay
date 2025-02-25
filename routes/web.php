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
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RevenueController;
use App\Models\Package;

Route::get('/booking31/{package_id}', [BookingController::class, 'showForm'])->name('frm');

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
Route::get('/packages', function () {
    if (!session()->has('admin')) {
        return redirect()->route('adminlogin'); // Redirects to login page if no session
    }
    $packages = Package::all();
    return view('packages', compact('packages')); // packages form page view
})->name('packages');
Route::get('/adminlogin', function () {
    return view('adminlogin'); // Admin login page view
})->name('adminlogin');

// Dashboard route
Route::get('/dashboard', function () {
    if (!session()->has('admin')) {
        return redirect()->route('adminlogin'); // Redirects to login page if no session
    }
    $bookingCount = Booking::count();
    $bookings = Booking::all(); 

    // Fetch only the count of canceled bookings
    $canceledBookingsCount = Booking::where('status', 'Canceled')->count(); 
    return view('dashboard', compact('bookingCount','canceledBookingsCount')); // Displays the dashboard with booking count
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
// Package listing page (shows available booking packages)
Route::get('/book', [BookingController::class, 'showPackages'])->name('book');


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

Route::get('/viewreviews', function () {
    return view('viewreviews'); // Admin logout page view
})->name('viewreviews');

// Route::get('/revenues', function () {
//     return view('revenues'); // Admin logout page view
// })->name('revenues');

// Route::get('/editpackages', function () {
//        $packages = Package::all();
//     return view('editpackages',compact('packages')); 
// })->name('editpackages');
Route::get('/editpackages/{id}', [BookingController::class, 'edit'])->name('editpackages');
Route::put('/editpackages/{id}', [PackageController::class, 'update'])->name('editpackages.update'); // Handle Update Request


// Route::get('/admin_calendar', function () {
//     return view('admin_calendar'); // calendar
// })->name('admin_calendar');


// Admin home page route
Route::get('/adminhome', function () {
    return view('adminhome'); // Admin home page view
})->name('adminhome');

Route::get('/archives', function () {
    return view('archives'); 
})->name('archives');

// Admin logout and session invalidate route
Route::get('/adminhome12', function () {
    Auth::logout(); 
    session()->invalidate(); 
    session()->regenerateToken(); 
    return redirect()->route('adminhome');
});
// Route to handle clear out of tracking code
Route::post('/clear-tracking-code', function() {
    session()->forget('tracking_code');
    return response()->json(['message' => 'Tracking code cleared']);
})->name('clear.tracking.code');
// Route to display booking data by tracking code
Route::post('/trackbooking', [BookingController::class, 'trackBooking'])->name('trackbooking');

Route::patch('/cancel-booking/{bookingId}', [BookingController::class, 'cancel'])->name('booking.cancel');

// ** New Route to Update Booking Status to "Done" **
Route::patch('/admin/bookings/{id}', [AdminController::class, 'updateBookingsStatus'])->name('admin.updateBookingsStatus');
//**Route for uploading */
Route::get('/editgallery', [GalleryController::class, 'create'])->name('gallery.create');
Route::post('gallery/store', [GalleryController::class, 'store'])->name('gallery.store');
Route::delete('/gallery/delete-multiple', [GalleryController::class, 'destroyMultiple'])->name('gallery.destroyMultiple');
Route::get('/gallerysection', [GalleryController::class, 'gallerysection'])->name('gallerysection');
Route::get('/bookings/packages', [BookingController::class, 'showPackages'])->name('bookings.packages');
Route::post('/bookform', [BookingController::class, 'store'])->name('bookform.store');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
Route::get('/reviews', [ReviewController::class, 'reviews'])->name('reviews.index'); //If you have an index page
// Route::get('/revenue-data', [RevenueController::class, 'getRevenueData']);
Route::get('/archives', [AdminController::class, 'archivedBookings'])->name('admin.archivedBookings');
Route::delete('/admin/bookings/archives/bulk-delete', [AdminController::class, 'bulkDeleteArchivedBookings'])
    ->name('admin.bulkDeleteArchivedBookings');

Route::get('/b00kings', [BookingController::class, 'showBookings'])->name('b00kings');
Route::get('/calendar', [BookingController::class, 'calendar'])->name('bookings.calendar');
Route::get('/cancelrequestA', [BookingController::class, 'canceledBookings'])->name('admin.canceledBookings');


Route::get('/approve_book/{id}', [BookingController::class, 'approveBooking'])->name('approve.booking');
Route::get('/reject_book/{id}', [BookingController::class, 'rejectBooking'])->name('reject.booking');
Route::get('/approvedCanceled', [BookingController::class, 'showApprovedBookings'])->name('approved.bookings');
Route::delete('/admin/bookings/approved/bulk-delete', [AdminController::class, 'bulkDeleteApprovedBookings'])
    ->name('admin.bulkDeleteApprovedBookings');

Route::get('/get-unavailable-dates', [BookingController::class, 'getUnavailableDates'])->name('get.unavailable.dates');
Route::get('/total-revenues', [RevenueController::class, 'totalRevenues'])->name('total.revenues');
Route::get('/user/calendar', [BookingController::class, 'calendars'])->name('user.calendar')->defaults('userView', true);
// Route::get('/admin/bookings/{booking}/mark-downpayment-paid', [BookingController::class, 'showMarkDownpaymentPaid'])->name('admin.mark.downpayment.paid');
// Route::post('/admin/bookings/{booking}/mark-downpayment-paid/process', [BookingController::class, 'processMarkDownpaymentPaid'])->name('admin.mark.downpayment.paid.process');
Route::post('/bookings/{booking}/upload-proof', [BookingController::class, 'uploadProofOfPayment'])->name('booking.upload.proof');
Route::get('/statistics', [RevenueController::class, 'statistics'])->name('statistics');

Route::put('/b00kings/{id}/update', [BookingController::class, 'updateUser'])->name('b00kings.update.user');
Route::get('/booking/{id}/edit', [BookingController::class, 'showEditUser'])->name('booking.edit.user.page');

Route::get('/approved-bookings', [AdminController::class, 'showApprovedBookings'])->name('approved.bookings');
Route::post('/bookings/delete-multiple', [BookingController::class, 'deleteMultiple']);
Route::get('/filter_bookings/{status}', [BookingController::class, 'filterBookings']);

Route::get('/filter_bookings', function () {
    $bookings = \App\Models\Booking::paginate(5);
    return view('filter_bookings', compact('bookings'));
});
