<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
    ];

    // relation to product details
    public function details()
    {
        return $this->hasMany(ProductDetail::class, 'product_id');
    }
}
