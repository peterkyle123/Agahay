<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);
        Admin::create([
            'name' => 'Admin User',
            'email' => 'pkyle.gingo@gmail.com',
            'password' => Hash::make('password'),
        ]);
        
        
    }
}
