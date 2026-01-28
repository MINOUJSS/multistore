<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProductCoupons extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_id',
        'product_id',
    ];

    // get coupon
    public function coupon()
    {
        return $this->belongsTo(userCoupons::class, 'coupon_id');
    }

    // get product
    public function product()
    {
        return $this->belongsTo(SellerProducts::class, 'product_id');
    }
}
