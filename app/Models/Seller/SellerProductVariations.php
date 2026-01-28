<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProductVariations extends Model
{
    use HasFactory;

    protected $fillable = [
        'product-id',
        'sku',
        'color',
        'size',
        'weight',
        'additional_price',
        'stock_quantity',
    ];

    public function product()
    {
        return $this->belongsTo(SellerProducts::class, 'product_id');
    }
}
