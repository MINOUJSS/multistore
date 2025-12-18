<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProductVideos extends Model
{
    use HasFactory;
     protected $fillable = [
        'product_id',
        'title',
        'type',
        'youtube_url',
        'youtube_id',
        'file_path',
        'file_disk',
        'description',
        'is_active',
        'sort_order',
    ];

    protected static function booted()
    {
        static::creating(function ($video) {
            if ($video->type === 'youtube' && $video->youtube_url) {
                preg_match('/(?:youtube\.com.*(?:\?|&)v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video->youtube_url, $matches);
                $video->youtube_id = $matches[1] ?? null;
            }
        });
    }

    public function getVideoUrlAttribute()
    {
        if ($this->type === 'local' && $this->file_path) {
            return asset('storage/' . $this->file_path);
        }

        if ($this->type === 'youtube' && $this->youtube_id) {
            return 'https://www.youtube.com/watch?v=' . $this->youtube_id;
        }

        return null;
    }

      public function product()
    {
        return $this->belongsTo(SupplierProducts::class);
    }
}
