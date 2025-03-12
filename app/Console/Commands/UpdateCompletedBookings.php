<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;

class UpdateCompletedBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:update-completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates booking status to "Done" when check-out date has passed.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $this->info("Current datetime: {$now}");

        $bookingsToUpdate = Booking::whereRaw(
            "STR_TO_DATE(CONCAT(check_out_date, ' ', check_out_time), '%Y-%m-%d %H:%i:%s') < ?",
            [$now]
        )
        ->where('status', 'Approved')
        ->get();

        // For testing, using raw update:
        $updatedRows = Booking::whereRaw(
            "STR_TO_DATE(CONCAT(check_out_date, ' ', check_out_time), '%Y-%m-%d %H:%i:%s') < ?",
            [$now]
        )
        ->where('status', 'Approved')
        ->update(['status' => 'Done']);

        $this->info("Updated $updatedRows bookings.");

        return 0;
    }
}
