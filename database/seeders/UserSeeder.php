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
        $faker = Faker::create();

        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->numberBetween(7000000000, 9999999999),
                'status' => $faker->randomElement([0, 1]),
                'company' => $faker->company,
                'password' => Hash::make('123456789'),
                'admin' => 0,
            ]);
        }

        // here one admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'support@mydreamstechnology.in',
            'phone' => '9999999999',
            'status' => 1,
            'company' => 'Admin Company',
            'password' => Hash::make('mydreams@123'),
            'admin' => 1,
        ]);

    }
}
