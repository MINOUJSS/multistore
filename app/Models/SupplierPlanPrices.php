<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPlanPrices extends Model
{
    use HasFactory;
    protected $fillable = ['plan_id', 'duration', 'price', 'discount'];

    public function plan()
    {
        return $this->belongsTo(SupplierPlan::class, 'plan_id');
    }
}
