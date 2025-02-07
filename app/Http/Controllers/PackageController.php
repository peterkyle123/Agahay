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

    public function editpackages()
    {
        $package = Package::all(); // Fetch all packages
        return view('editpackages', compact('package'));
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
    public function update(Request $request, $slug)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Find the package
        $package = Package::where('slug', $slug)->first();

        if (!$package) {
            return redirect()->route('admin.dashboard')->with('error', 'Package not found');
        }

        // Update the package description
        $package->description = $validated['description'];

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete the old image if exists (optional, depending on your use case)
            if ($package->image) {
                \Storage::delete('public/' . $package->image);
            }

            // Store the new image and update the image field in the database
            $imagePath = $request->file('image')->store('images', 'public');
            $package->image = $imagePath;
        }

        // Save the updated package
        $package->save();

        return redirect()->route('admin.edit', ['slug' => $package->slug])
                         ->with('success', 'Package updated successfully!');
    }
}
