<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerOrders extends Model
{
    use HasFactory;
    protected $fillable = ['seller_id', 'customer_name', 'phone', 'order_number', 'status', 'total_price', 'note', 'discount', 'shipping_cost', 'shipping_company', 'shipping_tracking_number', 'shipping_type', 'free_shipping', 'payment_method', 'payment_status', 'shipping_address', 'billing_address', 'order_date', 'phone_visiblity', 'country_id', 'wilaya_id', 'dayra_id', 'baladia_id', 'confirmed_by_user_id', 'confirmed_by_employee_id', 'confirmation_status', 'confirmed_at', 'ip_address', 'user_agent', 'device_fingerprint', 'session_id', 'risk_score', 'risk_indicators', 'fraud_score', 'fraud_status', 'reviewed_at'];

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
        return $this->hasMany(SellerOrderItems::class, 'order_id');
    }
}
