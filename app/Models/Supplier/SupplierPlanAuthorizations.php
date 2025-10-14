<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPlanAuthorizations extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'plan_id',
        'permission_key',
        'permission_value',
        'is_enabled',
    ];
    //
    public function plan()
    {
        return $this->belongsTo(SupplierPlan::class, 'plan_id');
    }
}
