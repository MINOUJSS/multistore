<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProductVariations extends Model
{
    use HasFactory;
    //
    protected $fillable=[
        'product-id',
        'sku',
        'color',
        'size',
        'weight',
        'additional_price',
        'stock_quantity',
    ];
    //
    public function product()
    {
        return $this->belongsTo(SupplierProducts::class, 'product_id');
    }
}
