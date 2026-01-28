<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerOrderItems extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'product_id', 'variation_id', 'attribute_id', 'quantity', 'unit_price', 'total_price'];

    public function order()
    {
        return $this->belongsTo(SellerOrders::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(SellerProducts::class, 'product_id');
    }

    public function variation()
    {
        return $this->belongsTo(SellerProductVariations::class, 'variation_id');
    }

    public function attribute()
    {
        return $this->belongsTo(SellerProductAttributes::class, 'attribute_id');
    }
}
