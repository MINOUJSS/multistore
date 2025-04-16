<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'user_id',
        'balance',
        'outstanding_amount',
        'created_at',
        'updated_at'
    ];
}
