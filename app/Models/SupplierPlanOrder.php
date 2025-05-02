<?php

namespace App\Models;

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
        'status',
        'payment_status',
        'start_date',
        'end_date'
    ];
}
