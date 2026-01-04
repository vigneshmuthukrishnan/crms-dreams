<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    
    protected $fillable = [
        'name', 'email', 'phone_1', 'phone_2', 'logo', 'fax', 'website',
        'owner', 'source', 'industry', 'type', 'tags', 'description', 'address',
        'country', 'state', 'city', 'zipcode', 'facebook_url',
        'linkedin_url', 'instagram_url', 'whatsapp_url',
        'created_by', 'updated_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // how to create attributes
    public function getLogoUrlAttribute()
    {
        // here storage path to url conversion logic
        return $this->logo ? asset('storage/' . $this->logo) : asset('assets/img/company.jpg');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'company_id');
    }

    public function oneLead()
    {
        return $this->hasOne(Lead::class, 'company_id');
    }
}
