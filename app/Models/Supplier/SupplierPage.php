<?php

namespace App\Models\Supplier;

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
    // 
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
