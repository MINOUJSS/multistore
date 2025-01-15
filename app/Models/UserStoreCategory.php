<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStoreCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'category_id',
        'image',
        'icon',
        'order',
    ];

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع الأقسام
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
