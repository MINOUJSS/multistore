<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCompaines extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'name',
        'data',
        'status',
    ];
}
