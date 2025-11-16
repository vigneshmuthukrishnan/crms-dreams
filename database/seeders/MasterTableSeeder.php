<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packageTypes = [
            'BulkSMS',
            'SMS API',
            'Voice Call',
            'Bulk Email',
            'IVR Service',
            'Official WhatsApp',
            'WhatsApp Generic',
        ];

        foreach ($packageTypes as $type) {
            DB::table('package_types')->insert([
                'name' => $type,
                'status' => 1, // Active
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        $statuses = [
            'RNR',
            'Invalid Number',
            'Followup',
            'Closed',
            'Not Interested',
            'Future Requirement',
        ];

        foreach ($statuses as $status) {
            DB::table('statuses')->insert([
                'name' => $status,
                'status' => 1, // Active
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
