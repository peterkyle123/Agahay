<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Admin;

Route::post('/login1', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);
    $admin = Admin::where('email', $request->email)->first();

    if ($admin && Hash::check($request->password, $admin->password)) {
        session(['admin' => $admin->id]); // Store admin session
        return redirect()->route('dashboard');
    }

    return back()->withErrors(['Invalid credentials']);
})->name('login1');
Route::get('/', function () {
    return view('index');
});

Route::get('/book', function () {
    return view('book');
})->name('book');
Route::get('/booking', function () {
    return view('booking');
})->name('booking');
Route::get('/adminlogin', function () {
    return view('adminlogin');
})->name('adminlogin');
Route::get('/dashboard', function () {
    if (!session()->has('admin')) {
        return redirect()->route('adminlogin');
    }
    return view('dashboard');
})->name('dashboard');
Route::get('/adminprofile', function () {
    return view('adminprofile');
})->name('adminprofile');
Route::delete('/admin/bookings', [BookingController::class, 'deleteBookings'])->name('admin.deleteBookings');
Route::get('/packages', [PackageController::class, 'show'])->name('packages');
Route::get('/b00kings1', [BookingController::class, 'b00kings'])->name('b00kings1');
Route::post('/bookstore', [BookingController::class, 'bookstore'])->name('bookstore');
Route::post('/bookform', [BookingController::class, 'store'])->name('bookform.store'); 
Route::get('/aboutus', function () {
    return view('aboutus');
})->name('aboutus');
Route::get('/gallerysection', function () {
    return view('gallerysection');
})->name('gallerysection');
Route::get('/trackbooking', function () {
    return view('trackbooking');
})->name('trackbooking');
Route::get('/b00kings', function () {
    return view('b00kings');
})->name('b00kings');
Route::get('/adminlogout', function () {
    return view('adminlogout');
})->name('adminlogout');
Route::get('/adminhome', function () {
    return view('adminhome');
})->name('adminhome');

Route::get('/adminhome1', function () {
    Auth::logout();  // Logs out the current user
    session()->invalidate();  // Clears the session data
    session()->regenerateToken();  // Regenerates the CSRF token

    return redirect()->route('adminhome');  // Redirects to the admin login page
});
