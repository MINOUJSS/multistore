<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userCoupons extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'user_id',
        'code',
        'description',
        'type',
        'value',
        'min_order_amount',
        'start_date',
        'end_date',
        'usage_limit',
        'usage_per_user',
        'is_active',
    ];
    protected $dates = ['start_date', 'end_date'];

    // public function users()
    // {
    //     return $this->belongsToMany(User::class);
    // }

    // public function categories()
    // {
    //     return $this->belongsToMany(UserCategoriesCoupons::class,'coupon_id');
    // }

    // public function Supplier_products()
    // {
    //     return $this->belongsToMany(SupplierProductsCoupons::class,'coupon_id');
    // }

    public function isExpired()
    {
        return $this->end_date < now();
    }

    public function isScheduled()
    {
        return $this->start_date > now();
    }

    public function isActive()
    {
        return $this->is_active && !$this->isExpired() && !$this->isScheduled();
    }
}
