<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'support@mydreamstechnology.in',
            'phone' => '7824998877',
            'status' => 1,
            'company' => 'Admin Company',
            'password' => Hash::make('mydreams@123'),
            'admin' => 1,
        ]);

    }
}
