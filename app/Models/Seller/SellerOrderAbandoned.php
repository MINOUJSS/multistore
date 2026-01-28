<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerOrderAbandoned extends Model
{
    use HasFactory;
    // protected $fillable = ['seller_id', 'customer_name','phone', 'order_number', 'status', 'total_price','note', 'shipping_cost', 'payment_method', 'payment_status', 'shipping_address', 'billing_address', 'order_date','phone_visiblity'];
    protected $fillable = ['seller_id', 'customer_name', 'phone', 'order_number', 'status', 'total_price', 'note', 'discount', 'shipping_cost', 'free_shipping', 'payment_method', 'payment_status', 'shipping_address', 'billing_address', 'order_date', 'phone_visiblity', 'wilaya_id', 'dayra_id', 'baladia_id', 'ip_address', 'user_agent', 'device_fingerprint', 'session_id', 'risk_score', 'risk_indicators', 'fraud_score', 'fraud_status', 'reviewed_at'];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(SellerOrderAbandonedItems::class, 'order_id');
    }
}
