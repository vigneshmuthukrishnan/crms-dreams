<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    
    protected $table = 'leads';
    
    protected $fillable = [
        'name',
        'customer_name',
        'company_name',
        'company_id',
        'company_type',
        'lead_source',
        'number',
        'email',
        'date',
        'plan',
        'package',
        'amount',
        'next_action_date',
        'status',
        'state',
        'city',
        'remarks',
        'assignee',
    ];

    // here company id reletion to company table
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // assignee relation to user table
    public function user()
    {
        return $this->belongsTo(User::class, 'assignee');
    }

    // lead activities relation
    public function activities()
    {
        return $this->hasMany(LeadActivity::class, 'lead_id')->orderBy('created_at', 'desc');
    }

    // Product relation 
    public function product()
    {
        return $this->belongsTo(Product::class, 'plan');
    }

    // ProductDetail relation
    public function productdetail()
    {
        return $this->belongsTo(ProductDetail::class, 'package');
    }
}
