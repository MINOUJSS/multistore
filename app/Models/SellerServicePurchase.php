<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerServicePurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'platform_service_id',
        'paid_amount',
        'status',
        'billing_type',
        'validity_days',
        'activated_at',
        'expires_at',
        'credits_total',
        'credits_remaining',
        'orders_total',
        'orders_remaining',
        'license_key',
        'meta_data',
    ];

    protected $casts = [
        'paid_amount' => 'decimal:2',
        'activated_at' => 'datetime',
        'expires_at' => 'datetime',
        'credits_total' => 'integer',
        'credits_remaining' => 'integer',
        'orders_total' => 'integer',
        'orders_remaining' => 'integer',
        'validity_days' => 'integer',
        'meta_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(PlatformService::class, 'platform_service_id');
    }

    /**
     * Check if the purchase/subscription is currently active
     */
    public function isActive(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        // If period-limited, check expiry
        if ($this->expires_at && Carbon::now()->greaterThan($this->expires_at)) {
            return false;
        }

        // If credit-pack, check remaining credits
        if ($this->billing_type === 'credit_pack' && $this->credits_remaining <= 0) {
            return false;
        }

        // If order-quota, check remaining orders
        if ($this->billing_type === 'order_quota' && $this->orders_remaining <= 0) {
            return false;
        }

        return true;
    }

    /**
     * Consume one order from this quota
     */
    public function consumeOrder(): bool
    {
        if ($this->orders_remaining > 0) {
            $this->decrement('orders_remaining');
            if ($this->orders_remaining <= 0 && $this->billing_type === 'order_quota') {
                $this->update(['status' => 'consumed']);
            }
            return true;
        }
        return false;
    }

    /**
     * Consume credits from this purchase
     */
    public function consumeCredits(int $amount = 10): bool
    {
        if ($this->credits_remaining >= $amount) {
            $this->decrement('credits_remaining', $amount);
            if ($this->credits_remaining <= 0 && $this->billing_type === 'credit_pack') {
                $this->update(['status' => 'consumed']);
            }
            return true;
        }
        return false;
    }

    /**
     * Calculate remaining days if period limited
     */
    public function getRemainingDaysAttribute(): ?int
    {
        if (!$this->expires_at) {
            return null;
        }

        $now = Carbon::now();
        if ($now->greaterThan($this->expires_at)) {
            return 0;
        }

        return (int) $now->diffInDays($this->expires_at);
    }
}
