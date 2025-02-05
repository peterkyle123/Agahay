<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            // If successful, redirect to the dashboard
            return redirect()->route('dashboard');
        }

        // If authentication fails, redirect back with an error
        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }
}

