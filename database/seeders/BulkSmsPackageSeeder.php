<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BulkSmsPackage;

class BulkSmsPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'package_name' => 'BulkSMS-Package-1',
                'quantity' => 10000,
                'sms_cost' => 0.25,
                'amount' => 2500,
                'offer_amount' => 2500,
                'gst' => 450,
                'total' => 2950,
            ],
            [
                'package_name' => 'BulkSMS-Package-2',
                'quantity' => 25000,
                'sms_cost' => 0.20,
                'amount' => 5000,
                'offer_amount' => 4500,
                'gst' => 810,
                'total' => 5310,
            ],
            [
                'package_name' => 'BulkSMS-Package-3',
                'quantity' => 50000,
                'sms_cost' => 0.16,
                'amount' => 8000,
                'offer_amount' => 6000,
                'gst' => 1080,
                'total' => 7080,
            ],
            [
                'package_name' => 'BulkSMS-Package-4',
                'quantity' => 100000,
                'sms_cost' => 0.13,
                'amount' => 13000,
                'offer_amount' => 11000,
                'gst' => 1980,
                'total' => 12980,
            ],
            [
                'package_name' => 'BulkSMS-Package-5',
                'quantity' => 100000,
                'sms_cost' => 0.14,
                'amount' => 8000,
                'offer_amount' => 7000,
                'gst' => 1260,
                'total' => 8260,
            ],
            [
                'package_name' => 'BulkSMS-Package-6',
                'quantity' => 1000000,
                'sms_cost' => 0.12,
                'amount' => 13000,
                'offer_amount' => 12000,
                'gst' => 2160,
                'total' => 14160,
            ],
            [
                'package_name' => 'BulkSMS-Package-7',
                'quantity' => 3000000,
                'sms_cost' => 0.11,
                'amount' => 39000,
                'offer_amount' => 33000,
                'gst' => 5940,
                'total' => 38940,
            ],
            [
                'package_name' => 'BulkSMS-Package-8',
                'quantity' => 5000000,
                'sms_cost' => 0.10,
                'amount' => 60000,
                'offer_amount' => 50000,
                'gst' => 9000,
                'total' => 59000,
            ],
            [
                'package_name' => 'BulkSMS-Package-9',
                'quantity' => 100000,
                'sms_cost' => 0.10,
                'amount' => 10000,
                'offer_amount' => 10000,
                'gst' => 1800,
                'total' => 11800,
            ],
        ];

        foreach ($packages as $package) {
            BulkSmsPackage::create($package);
        }
    }
}
