<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'tenant_id',
        'full_name',
        'last_name',
        'first_name',
        'store_name',
        'wilaya',
        'dayra',
        'baladia',
        'address',
        'status',
    ];
    /**
     * Get tenant information.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    } 
    /**
     * Get plan information.
     */
    public function plan_subscription()
    {
        return $this->hasOne(SupplierPlanSubscription::class);
    }
}
