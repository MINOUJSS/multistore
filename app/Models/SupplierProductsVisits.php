<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProductsVisits extends Model
{
    use HasFactory;
    //
    protected $fillable = ['product_id', 'ip_address', 'user_agent', 'user_id', 'visited_at'];

    public function product()
    {
        return $this->belongsTo(SupplierProducts::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
