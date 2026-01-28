<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPlanOrder extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'plan_id',
            'seller_id',
            'duration',
            'price',
            'discount',
            'payment_method',
            'payment_proof',
            'status',
            'payment_status',
            'start_date',
            'end_date',
        ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function plan()
    {
        return $this->belongsTo(SellerPlan::class, 'plan_id');
    }
}
