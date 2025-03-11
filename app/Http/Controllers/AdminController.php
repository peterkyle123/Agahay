<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\Log;
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
    public function updateBookingsStatus(Request $request, $id)
{
    $booking = Booking::findOrFail($id);
    $action = $request->input('action');

    if ($action === 'approve') {
        $booking->status = 'Approved';
        \Log::info('Booking ' . $id . ' approved.');
    } elseif ($action === 'decline') {
        $booking->status = 'Declined';
        $booking->decline_reason = $request->input('decline_reason'); // Store the decline reason
        $booking->save();
        return response()->json(['success' => 'Booking has been declined successfully.']);
    } elseif ($action === 'delete') {
        if ($booking->status === 'Declined') {
            $booking->delete();
            \Log::info('Booking ' . $id . ' deleted.');
            return redirect()->back()->with('success', 'Booking deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Only declined bookings can be deleted.');
        }
    }

    $booking->save(); // Save the updated status

    return redirect()->back()->with('success', 'Booking status updated.');
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
public function showApprovedBookings()
    {
        $bookings = Booking::where('status', 'Approved')->get();
        return view('approved_bookings', compact('bookings'));
    }

    // LATEST ADDED
    public function updatePayment(Request $request, $id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $booking->payment = $request->payment;
        $booking->save();

        return response()->json(['success' => 'Payment updated successfully']);
    }



}
