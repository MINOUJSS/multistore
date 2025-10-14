<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBlockedCustomers extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'ip_address',
        'device_fingerprint',
        'reason',
        'status',
    ];
}
