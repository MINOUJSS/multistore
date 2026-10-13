<?php

namespace App\Models\Seller;

use App\Models\Seller\Seller;
use App\Models\Seller\SellerProducts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProductLandingPage extends Model
{
    use HasFactory;

    protected $table = 'seller_product_landing_pages';

    protected $fillable = [
        'seller_id',
        'product_id',
        'title',
        'slug',
        'marketing_angle',
        'hero_headline',
        'hero_subheadline',
        'content_json',
        'theme_settings',
        'status',
        'views_count',
        'orders_count',
        'credits_used',
    ];

    protected $casts = [
        'content_json' => 'array',
        'theme_settings' => 'array',
        'views_count' => 'integer',
        'orders_count' => 'integer',
        'credits_used' => 'integer',
    ];

    protected $appends = [
        'marketing_angle_name',
        'public_url',
    ];

    public function product()
    {
        return $this->belongsTo(SellerProducts::class, 'product_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    /**
     * Get the marketing angle label in Arabic
     */
    public function getMarketingAngleNameAttribute(): string
    {
        return match ($this->marketing_angle) {
            'pain_relief' => 'حل مشكلة / راحة وألم',
            'gift' => 'هدية مثالية',
            'luxury' => 'فخامة ومكانة اجتماعية',
            'savings' => 'توفير وقيمة اقتصادية',
            'speed' => 'توفير الوقت والسهولة',
            'custom' => 'زاوية مخصصة',
            default => 'عامة / شاملة',
        };
    }

    /**
     * Get the public URL for the landing page
     */
    public function getPublicUrlAttribute(): string
    {
        $tenantId = $this->seller?->tenant_id;
        $tenantData = $tenantId ? get_tenant_data($tenantId) : null;
        $primaryDomain = $tenantData?->domains[0]?->domain ?? null;

        $scheme = 'http';
        if (app()->bound('request')) {
            $scheme = request()->server('REQUEST_SCHEME') ?: (request()->getScheme() ?: 'http');
        }

        if ($primaryDomain) {
            return $scheme . '://' . $primaryDomain . '/lp/' . $this->slug;
        }

        $host = app()->bound('request') ? request()->getHost() : (config('tenancy.central_domains')[0] ?? 'multistore.test');
        return $scheme . '://' . ($tenantId ?? 'store') . '.' . $host . '/lp/' . $this->slug;
    }
}
