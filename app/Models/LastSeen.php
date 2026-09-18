<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastSeen extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'device',
        'browser',
        'last_seen_at',
        'logged_in_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
