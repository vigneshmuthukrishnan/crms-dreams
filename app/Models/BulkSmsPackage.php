<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkSmsPackage extends Model
{
    use HasFactory;
    protected $table = 'bulk_sms_packages';

    protected $fillable = [
        'package_name',
        'quantity',
        'sms_cost',
        'amount',
        'offer_amount',
        'gst',
        'total'
    ];
}
