<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;

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
    return view('dashboard');
})->name('dashboard');
Route::get('/adminprofile', function () {
    return view('adminprofile');
})->name('adminprofile');
Route::post('/login', [AuthController::class, 'login'])->name('login'); 
Route::get('/packages', [PackageController::class, 'show'])->name('packages');
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