<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPlanPrices extends Model
{
    use HasFactory;
    protected $fillable = ['plan_id', 'duration', 'price', 'discount'];

    public function plan()
    {
        return $this->belongsTo(SellerPlan::class, 'plan_id');
    }
}
