<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProducts extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_id',
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'cost',
        'image',
        'qty',
        'minimum_order_qty',
        'condition',
        'free_shipping',
        'status',
    ];

    public function offers()
    {
        return $this->belongsToMany(SellerOffers::class, 'seller_offer_products');
    }

    // العلاقة مع المورد
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    // العلاقة مع الفئة
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variations()
    {
        return $this->hasMany(SellerProductVariations::class, 'product_id');
    }

    public function attributes()
    {
        return $this->hasMany(SellerProductAttributes::class, 'product_id');
    }

    public function images()
    {
        return $this->hasMany(SellerProductImages::class, 'product_id');
    }

    public function videos()
    {
        return $this->hasMany(SellerProductVideos::class, 'product_id');
    }

    public function ratings()
    {
        return $this->hasMany(SellerProductRatings::class, 'product_id');
    }

    public function discount()
    {
        return $this->hasOne(SellerProductDiscounts::class, 'product_id');
    }

    public function activeDiscount()
    {
        return $this->hasOne(SellerProductDiscounts::class, 'product_id')
                    ->where('status', 'active')
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now());
    }

    public function visits()
    {
        return $this->hasMany(ProductVisits::class, 'product_id');
    }

    public function visitCount()
    {
        return $this->visits()->count();
    }

    public function reviews()
    {
        return $this->hasMany(SellerProductReviews::class, 'product_id');
    }
}
