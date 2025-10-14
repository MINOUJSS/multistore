<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBenefitSection extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'order',
    ];
    //
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
