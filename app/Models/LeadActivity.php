<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadActivity extends Model
{
    use HasFactory;

    protected $table = 'lead_activities';

    protected $fillable = [
        'lead_id',
        'name',
        'type',
        'date',
        'time',
        'remark',
        'next_action_date',
        'status',
        'created_by',
        'updated_by',
    ];
}
