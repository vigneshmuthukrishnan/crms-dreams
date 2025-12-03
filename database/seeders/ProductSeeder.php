<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'BulkSMS', 'description' => 'Bulk SMS Service'],
            ['name' => 'WhatsApp', 'description' => 'WhatsApp Messaging Service'],
            ['name' => 'VoiceCall', 'description' => 'Voice Call Service'],
            ['name' => 'RCS', 'description' => 'Rich Communication Services'],
            ['name' => 'IVR', 'description' => 'Interactive Voice Response Service'],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
