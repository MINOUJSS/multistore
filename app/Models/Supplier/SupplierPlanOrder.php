<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPlanOrder extends Model
{
    use HasFactory;
    //
    protected $fillable=
    [
        'plan_id',
        'supplier_id',
        'duration',
        'price',
        'discount',
        'payment_method',
        'payment_proof',
        'status',
        'payment_status',
        'start_date',
        'end_date'
    ];
    //
    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
    //
    public function plan()
    {
        return $this->belongsTo(SupplierPlan::class,'plan_id');
    }
}
