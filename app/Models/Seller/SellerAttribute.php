<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'slug',
    ];

    public function productAttributes()
    {
        return $this->hasMany(SellerProductAttributes::class, 'attribute_id');
    }
}
