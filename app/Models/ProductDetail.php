<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $table = 'product_details';

    protected $fillable = [
        'product_id',
        'quantity',
        'cost',
        'with_out',
        'amount',
        'discount',
        'gst',
        'total',
    ];

    // relation to product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
