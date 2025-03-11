<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function create()
    {
        if (!session()->has('admin')) {
            return redirect()->route('adminlogin'); // Redirects to login page if no session
        }
        $galleryItems = Gallery::all();
        return view('editgallery', compact('galleryItems'));
    }

    public function store(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'description' => 'nullable|string|max:255',
        ]);

        // Store the image
        $imagePath = $request->file('image')->store('gallery_images', 'public');

        // Save the image data to the database
        $galleryItem = new Gallery();
        $galleryItem->image_name = $request->file('image')->getClientOriginalName();
        $galleryItem->image_path = $imagePath;
        $galleryItem->description = $request->description;
        $galleryItem->save();

        // Redirect to the upload form with success message or view gallery page
        return redirect()->back()->with('success', 'Image uploaded successfully');
    }
    public function destroyMultiple(Request $request)
    {
        $imageIds = $request->input('selectedImages');

        if (!$imageIds) {
            return redirect()->back()->with('error', 'No images selected.');
        }

        Gallery::whereIn('id', $imageIds)->delete();

        return redirect()->back()->with('success', 'Selected images deleted successfully.');
    }
    public function gallerysection()
{
    $galleryItems = Gallery::all(); // Fetch all images from the database
    return view('gallerysection', compact('galleryItems'));
}
}
