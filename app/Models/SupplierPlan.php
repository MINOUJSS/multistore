<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPlan extends Model
{
    use HasFactory;
    //
    protected $fillable = ['name', 'description', 'price'];

    public function features()
    {
        return $this->hasMany(SupplierPlanFeature::class);
    }
    //
    public function pricing()
    {
        return $this->hasMany(SupplierPlanPrices::class, 'plan_id');
    }
}