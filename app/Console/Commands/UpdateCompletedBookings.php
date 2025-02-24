<?php

namespace App\Console\Commands; // Add the correct namespace

use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateCompletedBookings extends Command
{
    protected $signature = 'bookings:update-completed';
    protected $description = 'Updates approved bookings to Done status after their checkout date.';

    public function handle() // Use handle() instead of fire()
    {
        $today = Carbon::today();

        $bookings = Booking::where('status', 'Approved')
            ->where('check_out_date', '<', $today)
            ->get();

        foreach ($bookings as $booking) {
            $booking->status = 'Done';
            $booking->save();
            Log::info('Booking ' . $booking->id . ' marked as Done.');
        }

        $this->info('Completed bookings updated.');
    }
}