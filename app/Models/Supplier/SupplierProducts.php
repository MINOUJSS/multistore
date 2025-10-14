<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProducts extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
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
        return $this->belongsToMany(SupplierOffers::class, 'supplier_offer_products');
    }
      // العلاقة مع المورد
      public function supplier()
      {
          return $this->belongsTo(Supplier::class);
      }
  
      // العلاقة مع الفئة
      public function category()
      {
          return $this->belongsTo(Category::class);
      }
      //
      public function variations()
      {
          return $this->hasMany(SupplierProductVariations::class, 'product_id');
      }
  
      public function attributes()
      {
          return $this->hasMany(SupplierProductAttributes::class, 'product_id');
      }

      //
      public function images()
      {
          return $this->hasMany(SupplierProductImages::class, 'product_id');
      }
      //
      public function ratings()
      {
          return $this->hasMany(SupplierProductRatings::class, 'product_id');
      }
      //
      public function discount()
      {
          return $this->hasOne(SupplierProductDiscounts::class, 'product_id');
      }
  
      public function activeDiscount()
      {
          return $this->hasOne(SupplierProductDiscounts::class, 'product_id')
                      ->where('status', 'active')
                      ->whereDate('start_date', '<=', now())
                      ->whereDate('end_date', '>=', now());
      }
      //
      public function visits()
      {
          return $this->hasMany(ProductVisits::class, 'product_id');
      }
  
      public function visitCount()
      {
          return $this->visits()->count();
      }
    //
    public function reviews()
    {
        return $this->hasMany(SupplierProductsReviews::class, 'product_id');
    }
}
