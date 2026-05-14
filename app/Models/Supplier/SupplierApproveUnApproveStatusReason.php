<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierApproveUnApproveStatusReason extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'admin_id',
        'status',
        'reason',
    ];

    public function supplier()
    {
        return $this->belongsTo(
            Supplier::class,
            'supplier_id'
        );
    }
}
