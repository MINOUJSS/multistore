<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProductAttributes extends Model
{
    use HasFactory;
    //
    protected $fillable=[
        'product_id',
        'attribute_id',
        'value',
        'additional_price',
        'stock_quantity',
    ];
    //
    public function product()
    {
        return $this->belongsTo(SupplierProducts::class, 'product_id');
    }

    public function attribute()
    {
        return $this->belongsTo(SupplierAttribute::class, 'attribute_id');
    }

}
