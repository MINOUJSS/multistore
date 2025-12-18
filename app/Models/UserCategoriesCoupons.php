<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategoriesCoupons extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'category_id',
        'coupon_id',
    ];

    //get coupon
    public function coupon()
    {
        return $this->belongsTo(userCoupons::class, 'coupon_id');
    }
    //get category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
