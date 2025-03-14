<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPage extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
        'supplier_id',
    ];
}
