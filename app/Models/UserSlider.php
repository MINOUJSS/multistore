<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'link',
        'target_type',
        'target_id',
        'status',
        'order',
    ];
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
