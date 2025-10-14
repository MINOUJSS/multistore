<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierFqa extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
        'answer',
        'supplier_id',
        'order',
        'status',
    ];
}
