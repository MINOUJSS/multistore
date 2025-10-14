<?php

namespace App\Models\Supplier;

use App\Models\userCoupons;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierProductsCoupons extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'coupon_id',
        'product_id',
    ];
    //get coupon
    public function coupon()
    {
        return $this->belongsTo(userCoupons::class, 'coupon_id');
    }

    // get product
    public function product()
    {
        return $this->belongsTo(SupplierProducts::class, 'product_id');
    }
}
