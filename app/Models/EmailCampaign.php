<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'title',
        'subject',
        'content',
        'target_audience',
        'status',
        'total_recipients',
        'sent_count',
        'failed_count',
        'scheduled_at',
        'sent_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    /**
     * Relationship with the admin who created the campaign.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Relationship with campaign send logs.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(EmailCampaignLog::class, 'campaign_id');
    }

    /**
     * Get target audience label in Arabic.
     */
    public function getTargetAudienceLabelAttribute(): string
    {
        return match ($this->target_audience) {
            'all_sellers' => 'جميع البائعين',
            'inactive_sellers' => 'البائعين غير النشطين (سجلوا ولم يعودوا)',
            'all_suppliers' => 'جميع الموردين',
            'inactive_suppliers' => 'الموردين غير النشطين',
            'all' => 'جميع المستخدمين (بائعين وموردين)',
            default => 'مخصص',
        };
    }

    /**
     * Calculate success rate percentage.
     */
    public function getSuccessRateAttribute(): int
    {
        if ($this->total_recipients <= 0) {
            return 0;
        }

        return (int) round(($this->sent_count / $this->total_recipients) * 100);
    }
}
