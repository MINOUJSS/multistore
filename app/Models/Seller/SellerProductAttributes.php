<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProductAttributes extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'attribute_id',
        'value',
        'additional_price',
        'stock_quantity',
    ];

    public function product()
    {
        return $this->belongsTo(SellerProducts::class, 'product_id');
    }

    public function attribute()
    {
        return $this->belongsTo(SellerAttribute::class, 'attribute_id');
    }
}
