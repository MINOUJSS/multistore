<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPlanFeature extends Model
{
    use HasFactory;
    protected $fillable = ['plan_id', 'feature_name', 'feature_value'];

    public function plan()
    {
        return $this->belongsTo(SellerPlan::class);
    }
}
