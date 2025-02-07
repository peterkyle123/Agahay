<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Update selected bookings' status to 'Done'
    public function updateBookingsStatus(Request $request)
{
    // Validate that the bookings are selected
    $request->validate([
        'bookings' => 'required|array|min:1',
        'bookings.*' => 'exists:bookings,id',
    ]);

    $action = $request->input('action');

    if ($action === 'done') {
        // Update selected bookings' status to "Done"
        Booking::whereIn('id', $request->bookings)->update(['status' => 'Done']);
        return redirect()->back()->with('success', 'Selected bookings marked as Done');
    }

    if ($action === 'delete') {
        // Delete selected bookings
        Booking::whereIn('id', $request->bookings)->delete();
        return redirect()->back()->with('success', 'Selected bookings deleted');
    }

    return redirect()->back()->with('error', 'Invalid action');
}

}
