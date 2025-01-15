<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProductRatings extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id', 'rating', 'review'];

    public function product()
    {
        return $this->belongsTo(SupplierProducts::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
