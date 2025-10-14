<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierAttribute extends Model
{
    use HasFactory;
    //
    protected $fillable=[
        'name',
        'user_id',
        'slug',
    ];
    //
    public function productAttributes()
    {
        return $this->hasMany(SupplierProductAttributes::class, 'attribute_id');
    }
}
