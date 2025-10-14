<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierOrderAbandonedItems extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'product_id', 'variation_id', 'quantity', 'unit_price', 'total_price'];

    public function order()
    {
        return $this->belongsTo(SupplierOrderAbandoned::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(SupplierProducts::class, 'product_id');
    }

    public function variation()
    {
        return $this->belongsTo(SupplierProductVariations::class, 'variation_id');
    }

    public function attribute()
    {
        return $this->belongsTo(SupplierProductAttributes::class, 'attribute_id');
    }
}
