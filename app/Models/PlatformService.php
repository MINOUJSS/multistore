<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformService extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'icon',
        'category',
        'price',
        'billing_type',
        'validity_days',
        'credits_amount',
        'orders_limit',
        'badge_text',
        'badge_color',
        'features',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'validity_days' => 'integer',
        'credits_amount' => 'integer',
        'orders_limit' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Relationship with purchases
     */
    public function purchases()
    {
        return $this->hasMany(SellerServicePurchase::class, 'platform_service_id');
    }

    /**
     * Scope for active services
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc');
    }

    /**
     * Check billing type
     */
    public function isOrderQuota(): bool
    {
        return $this->billing_type === 'order_quota' || !empty($this->orders_limit);
    }

    public function isCreditPack(): bool
    {
        return $this->billing_type === 'credit_pack';
    }

    public function isLimitedPeriod(): bool
    {
        return $this->billing_type === 'limited_period';
    }

    public function isOneTime(): bool
    {
        return $this->billing_type === 'one_time';
    }

    /**
     * Calculate price per order for quota packages
     */
    public function getPricePerOrderAttribute(): ?float
    {
        if ($this->orders_limit && $this->orders_limit > 0) {
            return round((float) $this->price / $this->orders_limit, 1);
        }
        return null;
    }
}
