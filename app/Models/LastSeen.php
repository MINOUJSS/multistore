<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastSeen extends Model
{
    use HasFactory;
    //
    protected $fillable=[
        'user_id',
        'ip_address',
        'device',
        'browser',
        'logged_in_at',
    ];
}
