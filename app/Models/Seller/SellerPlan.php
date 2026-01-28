<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPlan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];

    public function features()
    {
        return $this->hasMany(SellerPlanFeature::class, 'plan_id');
    }

    public function pricing()
    {
        return $this->hasMany(SellerPlanPrices::class, 'plan_id');
    }

    public function Authorizations()
    {
        return $this->hasMany(SellerPlanAuthorizations::class, 'plan_id');
    }
}
