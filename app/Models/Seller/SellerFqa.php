<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerFqa extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
        'answer',
        'seller_id',
        'order',
        'status',
    ];
}
