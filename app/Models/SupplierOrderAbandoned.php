<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierOrderAbandoned extends Model
{
    use HasFactory;
    protected $fillable = ['supplier_id', 'customer_name','phone', 'order_number', 'status', 'total_price', 'shipping_cost', 'payment_method', 'payment_status', 'shipping_address', 'billing_address', 'order_date'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(SupplierOrderAbandonedItems::class, 'order_id');
    }
}
