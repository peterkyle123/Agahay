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

        \Log::info("updateBookingsStatus called for booking: {$id} with action: {$action}");

        if ($action === 'approve') {
            // Retrieve the discount and final_payment arrays from the form submission
            $discounts = $request->input('discount');
            $final_payments = $request->input('final_payment');

            if (!isset($discounts[$id]) || !isset($final_payments[$id])) {
                return $request->expectsJson()
                    ? response()->json(['error' => 'Invalid data submitted for the booking.'], 422)
                    : redirect()->back()->with('error', 'Invalid data submitted for the booking.');
            }

            $discount = $discounts[$id];
            $final_payment = $final_payments[$id];

            // Update the booking record
            $booking->discount = $discount;
            $booking->payment  = number_format($final_payment, 2, '.', '');
            $booking->status   = 'Approved';
            $booking->save();

            \Log::info("Booking {$id} approved. Discount: {$discount} Final Payment: {$booking->payment}");

            // Return JSON if AJAX, otherwise redirect
            return $request->expectsJson()
                ? response()->json(['success' => 'Booking updated and discount applied successfully!'])
                : redirect()->back()->with('success', 'Booking updated and discount applied successfully!');
        }

        elseif ($action === 'decline') {
            // Set booking status to 'Declined' and record the decline reason
            $booking->status = 'Declined';
            $booking->decline_reason = $request->input('decline_reason');
            $booking->save();

            \Log::info("Booking {$id} declined with reason: " . $booking->decline_reason);

            // Return JSON if AJAX, otherwise redirect
            return $request->expectsJson()
                ? response()->json(['success' => 'Booking declined successfully.'])
                : redirect()->back()->with('success', 'Booking declined successfully!');
        }

        elseif ($action === 'delete') {
            if ($booking->status === 'Declined') {
                $booking->delete();
                \Log::info("Booking {$id} deleted.");

                return $request->expectsJson()
                    ? response()->json(['success' => 'Booking deleted successfully.'])
                    : redirect()->back()->with('success', 'Booking deleted successfully.');
            } else {
                return $request->expectsJson()
                    ? response()->json(['error' => 'Only declined bookings can be deleted.'], 422)
                    : redirect()->back()->with('error', 'Only declined bookings can be deleted.');
            }
        }
     elseif ($action === 'done') {
        // Only allow changing status from Approved to Done
        if ($booking->status === 'Approved') {
            $booking->status = 'Done';
            $booking->save();

            \Log::info("Booking {$id} marked as done.");

            return $request->expectsJson()
                ? response()->json(['success' => 'Booking marked as done successfully!'])
                : redirect()->back()->with('success', 'Booking marked as done successfully!');
        } else {
            return $request->expectsJson()
                ? response()->json(['error' => 'Only approved bookings can be marked as done.'], 422)
                : redirect()->back()->with('error', 'Only approved bookings can be marked as done.');
        }
    }

    return $request->expectsJson()
        ? response()->json(['error' => 'Invalid action.'], 400)
        : redirect()->back()->with('error', 'Invalid action.');
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
