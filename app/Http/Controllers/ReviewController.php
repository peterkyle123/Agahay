<?php

namespace App\Http\Controllers;
use App\Models\Review;
use Illuminate\Http\Request;
class ReviewController extends Controller
{
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255', // Email is optional
        'rating' => 'required|integer|min:1|max:5',
        'message' => 'required|string',
    ]);

    Review::create($validatedData);

    return back()->with('success', 'Thank you for your review!'); // Success message
}
public function edit(Review $review)
{
    return view('reviews.edit', compact('review')); // Create an edit view
}

public function update(Request $request, Review $review)
{
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
        ]);

        $review->update($validatedData);

        return redirect()->route('reviews.index')->with('success', 'Review updated!'); 
}

public function reviews()
    {
        if (!session()->has('admin')) {
            return redirect()->route('adminlogin'); // Redirects to login page if no session
        }
        $reviews = Review::all(); // Or use a more specific query if needed

        return view('viewreviews', compact('reviews'));
    }

public function destroy(Review $review)
{
    $review->delete();
    return redirect()->route('reviews.index')->with('success', 'Review deleted!');
}
}
