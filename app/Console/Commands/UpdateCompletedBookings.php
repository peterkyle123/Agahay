<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;

class UpdateCompletedBookings extends Command
{
    protected $signature = 'bookings:update-completed';
    protected $description = 'Updates booking status to "Done" when check-out date has passed.';

    public function handle()
    {
        $now = Carbon::now()->toDateString();

        $bookingsToUpdate = Booking::where('check_out_date', '<', $now)
            ->where('status', '!=', 'Done') // Prevents already done bookings from being re-updated
            ->get();

        foreach ($bookingsToUpdate as $booking) {
            $booking->status = 'Done';
            $booking->save();
            $this->info("Booking {$booking->id} updated to 'Done'.");
        }

        $this->info('Completed bookings update process finished.');
    }
}