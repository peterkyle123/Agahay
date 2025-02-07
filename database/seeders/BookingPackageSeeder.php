<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BookingPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('packages')->insert([
            [
                'package_name' => 'Small Group Package',
                'price' => 6500.00,
                'number_of_days' => 1,  
                'number_of_guests' => 10,
                'description' => 'Enjoy a private stay at Agahay Guesthouse. Includes full house access, free Wi-Fi, billiards, and videoke. Extra pax: ₱75 each.', 
                'image' => 'images/8.jpg'
            ],
            [
                'package_name' => 'VIP Booking',
                'price' => 10000.00,
                'number_of_days' => 2, 
                'number_of_guests' => 8,
                'description' => 'Experience premium luxury with our VIP package. Private amenities, enhanced comfort, and exclusive services.',
                'image' => 'images/VIP.jpg'
            ],
            [
                'package_name' => 'Large Group Package',
                'price' => 1200.00,
                'number_of_days' => 3,   
                'number_of_guests' => 30,
                'description' => 'Enjoy a private stay at Agahay Guesthouse. Includes full house access, free Wi-Fi, billiards, and videoke. Extra pax: ₱75 each.', 
                'image' => 'images/8.jpg'
            ],
        ]);
    }
}