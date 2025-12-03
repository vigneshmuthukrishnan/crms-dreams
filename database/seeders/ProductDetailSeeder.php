<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductDetail;

class ProductDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productDetailsData = [
            [
                'name' => 'BulkSMS',
                'details' => [
                    ['quantity' => '10000',  'cost' => 0.20, 'with_out' => 2500, 'amount' => 2000, 'discount' => 0, 'gst' => 360, 'total' => 2360],
                    ['quantity' => '25000',  'cost' => 0.16, 'with_out' => 5000, 'amount' => 4000, 'discount' => 0, 'gst' => 720, 'total' => 4720],
                    ['quantity' => '50000',  'cost' => 0.12, 'with_out' => 8000, 'amount' => 6000, 'discount' => 0, 'gst' => 1080, 'total' => 7080],
                    ['quantity' => '100000', 'cost' => 0.11, 'with_out' => 13000, 'amount' => 11000, 'discount' => 0, 'gst' => 1980, 'total' => 12980],
                    ['quantity' => '300000', 'cost' => 0.12, 'with_out' => 36000, 'amount' => 24000, 'discount' => 0, 'gst' => 4320, 'total' => 28320],
                    ['quantity' => '500000', 'cost' => 0.11, 'with_out' => 55000, 'amount' => 55000, 'discount' => 0, 'gst' => 9900, 'total' => 64900],
                    ['quantity' => 'RCS-1L', 'cost' => 0.18, 'with_out' => 0, 'amount' => 18000, 'discount' => 0, 'gst' => 3240, 'total' => 21240],
                ]
            ],
            [
                'name' => 'WhatsApp',
                'details' => [
                    ['quantity' => 'Yealy Rental',  'cost' => 0, 'with_out' => 0, 'amount' => 8000, 'discount' => 0, 'gst' => 1440, 'total' => 9440],
                    ['quantity' => 'Life Time',  'cost' => 0, 'with_out' => 0, 'amount' => 20000, 'discount' => 0, 'gst' => 3600, 'total' => 23600]
                ]
            ],
            [
                'name' => 'VoiceCall',
                'details' => [
                    ['quantity' => '10000',  'cost' => 0.35, 'with_out' => 0, 'amount' => 3500, 'discount' => 0, 'gst' => 630, 'total' => 4130],
                    ['quantity' => '25000',  'cost' => 0.30, 'with_out' => 0, 'amount' => 7500, 'discount' => 0, 'gst' => 1350, 'total' => 8850],
                    ['quantity' => '50000',  'cost' => 0.28, 'with_out' => 0, 'amount' => 14000, 'discount' => 0, 'gst' => 2520, 'total' => 16520],
                    ['quantity' => '100000',  'cost' => 0.25, 'with_out' => 0, 'amount' => 25000, 'discount' => 0, 'gst' => 4500, 'total' => 29500],
                ]
            ],
            [
                'name' => 'RCS',
                'details' => [
                    ['quantity' => '50000', 'cost' => 0, 'with_out' => 0, 'amount' => 15000, 'discount' => 0, 'gst' => 2700, 'total' => 17700],
                    ['quantity' => '100000', 'cost' => 0, 'with_out' => 0, 'amount' => 25000, 'discount' => 0, 'gst' => 4500, 'total' => 29500],
                ]
            ]
        ];


        foreach ($productDetailsData as $productData) {
            $product = Product::where('name', $productData['name'])->first();
            if ($product) {
                foreach ($productData['details'] as $detail) {
                    ProductDetail::create(array_merge(['product_id' => $product->id], $detail));
                }
            }
        }
    }
}
