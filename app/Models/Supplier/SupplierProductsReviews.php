<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProductsReviews extends Model
{
    use HasFactory;
    //
        protected $fillable = [
        'product_id',
        'rating',
        'comment'
    ];

    // العلاقة مع المنتج
    public function product()
    {
        return $this->belongsTo(SupplierProducts::class);
    }
}
