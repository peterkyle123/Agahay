<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class UpdateOverdueBookings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Update all overdue bookings whose status is still 'Approved'
        Booking::whereRaw(
            "STR_TO_DATE(CONCAT(check_out_date, ' ', check_out_time), '%Y-%m-%d %H:%i:%s') < ?",
            [Carbon::now()]
        )
        ->where('status', 'Approved')
        ->update(['status' => 'Done']);

        return $next($request);
    }
}
