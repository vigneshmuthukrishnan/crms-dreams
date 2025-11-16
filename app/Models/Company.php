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
        'owner', 'source', 'industry', 'tags', 'description', 'address',
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
        return $this->logo ? asset($this->logo) : null;
    }

}
