<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // public function approveCancellation($bookingId)
    // {
    //     $booking = Booking::find($bookingId);

    //     if (!$booking) {
    //         return redirect()->back()->with('error', 'Booking not found.');
    //     }

    //     if ($booking->cancellation_requested !== 'pending') {
    //         return redirect()->back()->with('error', 'Invalid cancellation request.');
    //     }

    //     $booking->status = 'Canceled';
    //     $booking->cancellation_requested = 'approved';
    //     $booking->save();

    //     return redirect()->back()->with('success', 'Cancellation approved.');
    // }
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
        // Only update "Pending" bookings to "Done" (Prevent "Canceled" bookings from being updated)
        $updated = Booking::whereIn('id', $request->bookings)
            ->where('status', 'Pending') // Allow only Pending bookings
            ->update(['status' => 'Done']);

        if ($updated) {
            return redirect()->back()->with('success', 'Selected bookings marked as Done.');
        } else {
            return redirect()->back()->with('error', 'Only Pending bookings can be marked as Done.');
        }
    }
    if ($action === 'delete') {
        // Retrieve only bookings with 'Done' or 'Canceled' status
        $validBookingIds = Booking::whereIn('id', $request->bookings)
            ->whereIn('status', ['Canceled'])
            ->pluck('id') // Get only valid IDs
            ->toArray(); // Convert to array
    
        if (empty($validBookingIds)) {
            return redirect()->back()->with('error', 'No valid bookings selected for deletion. Only Canceled bookings can be deleted.');
        }
    
        // Delete only the valid bookings (Done and Canceled)
        Booking::whereIn('id', $validBookingIds)->delete();
    
        return redirect()->back()->with('success', 'Successfully deleted Canceled bookings.');
    }
    

    return redirect()->back()->with('error', 'Invalid action');
}
public function archivedBookings()
{
    if (!session()->has('admin')) {
        return redirect()->route('adminlogin'); // Redirects to login page if no session
    }
    // Fetch only completed bookings with "Done" status
    $archivedBookings = Booking::where('status', 'Done')->get();

    return view('archives', compact('archivedBookings'));
}
public function bulkDeleteArchivedBookings(Request $request)
{
    if (!session()->has('admin')) {
        return redirect()->route('adminlogin'); // Redirect to login if not authenticated
    }

    $bookingIds = $request->input('booking_ids');

    if (!$bookingIds) {
        return redirect()->back()->with('error', 'No bookings selected for deletion.');
    }

    // Find and delete only 'Done' bookings
    $deleted = Booking::whereIn('id', $bookingIds)->where('status', 'Done')->delete();

    if ($deleted) {
        return redirect()->back()->with('success', 'Selected bookings permanently deleted.');
    } else {
        return redirect()->back()->with('error', 'Some selected bookings could not be deleted.');
    }
}
public function bulkDeleteApprovedBookings(Request $request)
{
    // Check if any bookings are selected
    if (!$request->has('booking_ids')) {
        return redirect()->back()->with('error', 'No bookings selected for deletion.');
    }

    // Get selected booking IDs
    $bookingIds = $request->input('booking_ids');

    // Delete only the bookings that have the "Canceled" status
    $deletedCount = Booking::whereIn('id', $bookingIds)
        ->where('status', 'Canceled')
        ->delete();

    if ($deletedCount > 0) {
        return redirect()->back()->with('success', "Successfully deleted $deletedCount canceled bookings.");
    } else {
        return redirect()->back()->with('error', 'No valid canceled bookings found for deletion.');
    }
}



        
        
}