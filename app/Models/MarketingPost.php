<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'platform',
        'hashtags',
        'source_data_summary',
        'prompt_used',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
