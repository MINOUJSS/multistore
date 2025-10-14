<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProductImages extends Model
{
    use HasFactory;
    //
    protected $fillable = ['product_id', 'image_path', 'is_primary', 'order'];

    public function product()
    {
        return $this->belongsTo(SupplierProducts::class, 'product_id');
    }
}
