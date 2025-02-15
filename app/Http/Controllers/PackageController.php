<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package; // Make sure you have a Package model

class PackageController extends Controller
{
    // Show all available packages
    public function show()
    {
        if (!session()->has('admin')) {
            return redirect()->route('adminlogin'); // Redirects to login page if no session
        }
        $packages = Package::all(); // Fetch all packages
        return view('packages', compact('packages'));
    }

    public function editpackages($id) {
        $packages = Package::find($id); // Fetch package details
        if (!session()->has('admin')) {
            return redirect()->route('adminlogin'); // Redirects to login page if no session
        }
        if (!$packages) {
            return abort(404); // Show a 404 error if no package is found
        }
    
        return view('editpackages', compact('packages')); // Pass $packages to the view
    }
    // Show the edit form for a specific package
    public function edit($slug)
    {
        
        $package = Package::where('slug', $slug)->first(); // Find the package by slug
        if (!$package) {
            return redirect()->route('admin.dashboard')->with('error', 'Package not found');
        }
        return view('admin.edit', compact('package')); // Return edit view with the package data
    }

    // Handle the update of the package
    public function update(Request $request, $id)
    {
        
         // Validate input data
         $request->validate([
            'package_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'number_of_days' => 'required|integer|min:1',
            'extra_pax_price' => 'required|numeric|min:0',
            'per_day_price' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'number_of_guests' => 'required|integer|min:2',
        ]);

        // Find the package by ID
        $package = Package::findOrFail($id);

        // Update package details
        $package->package_name = $request->package_name;
        $package->price = $request->price;
        $package->number_of_days = $request->number_of_days;
        $package->extra_pax_price = $request->extra_pax_price;
        $package->per_day_price = $request->per_day_price;
        $package->description = $request->description;
        $package->number_of_guests = $request->number_of_guests;
        // Save changes to the database
        $package->save();

        // Redirect with success message
        return redirect()->back()->with('success', 'Package updated successfully.');
    }
}
