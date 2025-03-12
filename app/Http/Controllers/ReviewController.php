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
            'email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
            'img_upld' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10000', // Corrected validation
        ]);

        // Handle the image upload
        if ($request->hasFile('img_upld')) {
            $imagePath = $request->file('img_upld')->store('reviews', 'public'); // Store in 'public/reviews'
            $validatedData['img_upld'] = $imagePath; // Store the path in the database
        }

        Review::create($validatedData);

        return back()->with('success', 'Thank you for your review!');
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
            'img_upld' => 'nullable|string|max:255',
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
public function toggleFeature($id)
{
    $review = Review::findOrFail($id);
    $review->featured = !$review->featured; // Toggle between 1 (featured) and 0 (not featured)
    $review->save();

    return redirect()->back()->with('success', 'Review updated successfully!');
}
//     public function index()
// {
//     $featuredReviews = Review::where('featured', true)->orderBy('created_at', 'desc')->get();
//     return view('home', compact('featuredReviews'));
// }


}
