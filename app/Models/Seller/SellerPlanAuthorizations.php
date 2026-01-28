<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPlanAuthorizations extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'permission_key',
        'permission_value',
        'is_enabled',
    ];

    public function plan()
    {
        return $this->belongsTo(SellerPlan::class, 'plan_id');
    }
}
