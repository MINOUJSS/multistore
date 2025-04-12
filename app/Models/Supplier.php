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
    //
    public function products()
    {
        return $this->hasMany(SupplierProducts::class);
    }
    //
    public function orders()
    {
        return $this->hasMany(SupplierOrders::class,'supplier_id');
    }
    //order today
    public function orderToDay()
    {
        return $this->hasMany(SupplierOrders::class,'supplier_id')
                    ->whereDate('created_at','=',now());
    }
    //order confirmed today
    public function orderConfirmedToDay()
    {
        return $this->hasMany(SupplierOrders::class,'supplier_id')
                    ->whereDate('updated_at','=',now())
                    ->where('status','=','processing');
    }
    //order canceled today 
    public function orderCanceledToDay()
    {
        return $this->hasMany(SupplierOrders::class,'supplier_id')
                    ->whereDate('updated_at','=',now())            
                    ->where('status','=','canceled');
    } 
    //order abandonte order to day
    public function orderAbandonedToDay()
    {
        return $this->hasMany(SupplierOrderAbandoned::class,'supplier_id')
                    ->whereDate('created_at','=',now());
    }

}
