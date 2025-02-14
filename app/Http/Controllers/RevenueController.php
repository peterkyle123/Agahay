<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    public function getRevenueData()
    {
        $revenues = DB::table('bookings')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(package_price + (extra_pax * pax_fee) * stay_days) as daily_revenue'),
                DB::raw('SUM(package_price + (extra_pax * pax_fee) * stay_days) OVER (PARTITION BY MONTH(created_at)) as monthly_revenue'),
                DB::raw('SUM(package_price + (extra_pax * pax_fee) * stay_days) OVER (PARTITION BY YEAR(created_at)) as annual_revenue')
            )
            ->groupBy('date')
            ->get();

        $totalRevenue = $revenues->sum('daily_revenue');
        $annualRevenue = $revenues->max('annual_revenue');
        $monthlyRevenue = $revenues->max('monthly_revenue');
        $dailyRevenue = $revenues->max('daily_revenue');

        return response()->json([
            'data' => $revenues,
            'total_revenue' => $totalRevenue,
            'annual_revenue' => $annualRevenue,
            'monthly_revenue' => $monthlyRevenue,
            'daily_revenue' => $dailyRevenue
        ]);
    }
}

