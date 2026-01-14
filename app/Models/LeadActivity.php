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

    // lead relation
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    // here i want company relation through lead table company_id
    public function company()
    {
        return $this->hasOneThrough(Company::class, Lead::class, 'id', 'id', 'lead_id', 'company_id');
    }

    // product relation through lead table product_id
    public function product()
    {
        return $this->hasOneThrough(Product::class, Lead::class, 'id', 'id', 'lead_id', 'plan');
    }

    // product detail relation through lead table product_detail_id
    public function productdetail()
    {
        return $this->hasOneThrough(ProductDetail::class, Lead::class, 'id', 'id', 'lead_id', 'package');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
