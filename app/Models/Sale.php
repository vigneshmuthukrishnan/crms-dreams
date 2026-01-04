<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'company_id',
        'lead_id',
        'order_no',
        'date',
        'invoice_no',
        'converted_invoice',
        'type',
        'gst_no',
        'payment_mode',
        'transaction_details',
        'product',
        'package',
        'amount',
        'gst',
        'grand_total',
        'created_by',
    ];


    protected static function boot()
    {
        $ordNoPrefix = env('ORD_NO_PREFIX', 'MDORD');
        parent::boot();
        static::creating(function ($sale) use ($ordNoPrefix) {
            $fy = self::financialYear();
            $lastOrder = self::where('order_no', 'like', "{$ordNoPrefix}{$fy}%")
                ->orderBy('id', 'desc')
                ->first();
            if ($lastOrder) {
                $lastNumber = intval(substr($lastOrder->order_no, -3));
                $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '001';
            }
            $sale->order_no = "{$ordNoPrefix}{$fy}{$newNumber}";
        });
    }

    private static function financialYear()
    {
        $year = now()->year;
        $month = now()->month;
        if ($month < 4) {
            return substr($year - 1, 2) . substr($year, 2);
        }
        return substr($year, 2) . substr($year + 1, 2);
    }


    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product');
    }

    public function productdetail()
    {
        return $this->belongsTo(ProductDetail::class, 'package');
    }
}
