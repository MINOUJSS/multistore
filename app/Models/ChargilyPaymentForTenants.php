<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargilyPaymentForTenants extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'user_id',
        'status',
        'currency',
        'amount',
        'payment_type',
        'payment_reference_id',
        'checkout_url',
        'created_at',
        'updated_at',
    ];
}
