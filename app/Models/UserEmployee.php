<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserEmployee extends Authenticatable
{
    use Notifiable;

    protected $table = 'user_employees';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
