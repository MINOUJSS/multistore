<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerOffers extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'status',
    ];

    public function products()
    {
        return $this->belongsToMany(SellerProducts::class, 'seller_offer_products');
    }
}
