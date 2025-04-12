<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingPrice extends Model
{
    use HasFactory;
    //
    protected $fillable=[
        'user_id',
        'wilaya_id',
        'stop_desck_price',
        'to_home_price',
        'additional_price',
        'shipping_available_to_wilaya',
        'shipping_available_to_stop_desck',
        'shipping_available_to_home',
        'additional_price_status',
    ];
}
