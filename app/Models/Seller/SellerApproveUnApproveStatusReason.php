<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerApproveUnApproveStatusReason extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'admin_id',
        'status',
        'reason',
    ];

    public function seller()
    {
        return $this->belongsTo(
            Seller::class,
            'seller_id'
        );
    }
}
