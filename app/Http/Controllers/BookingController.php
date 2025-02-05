<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    //
    public function index()
    {
        return view('book'); // This will render a view called 'booking.blade.php'
    }
}
