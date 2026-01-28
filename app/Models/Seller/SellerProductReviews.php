<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProductReviews extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'rating',
        'comment',
    ];

    // العلاقة مع المنتج
    public function product()
    {
        return $this->belongsTo(SellerProducts::class);
    }
}
