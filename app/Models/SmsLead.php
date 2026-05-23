<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLead extends Model
{
    use HasFactory;

    protected $table = 'tbl_sms_lead';

    protected $fillable = [
        'name',
        'phone',
        'looking_for',
        'otp',
        'verification',
        'status',
    ];
}
