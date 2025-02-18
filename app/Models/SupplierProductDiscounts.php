<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProductDiscounts extends Model
{
    use HasFactory;
    //
    protected $fillable=[
        'product_id',
        'discount_percentage',
        'discount_amount',
        'start_date',
        'end_date',
        'status',
    ];
}
