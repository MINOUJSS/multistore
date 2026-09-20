<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminBankAccount extends Model
{
    use HasFactory;

    protected $table = 'admin_bank_accounts';

    protected $fillable = [
        'admin_id',
        'account_type',
        'bank_name',
        'account_name',
        'account_number',
        'ccp_key',
        'rip',
        'iban',
        'swift_code',
        'notes',
        'is_active',
        'is_default',
        'logo',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    /**
     * Relationship with the Admin who registered or manages this account
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Scope for active bank accounts
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by account type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('account_type', $type);
    }

    /**
     * Human-readable type label in Arabic
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->account_type) {
            'baridimob' => 'بريدي موب (BaridiMob)',
            'ccp' => 'بريد الجزائر (CCP)',
            'bank' => 'حساب بنكي وطني',
            default => 'حساب مالي آخر',
        };
    }

    /**
     * Badge visual class based on account type
     */
    public function getTypeBadgeClassAttribute(): string
    {
        return match ($this->account_type) {
            'baridimob' => 'bg-success bg-opacity-10 text-success border border-success border-opacity-25',
            'ccp' => 'bg-warning bg-opacity-15 text-warning-emphasis border border-warning border-opacity-25',
            'bank' => 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25',
            default => 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25',
        };
    }

    /**
     * Card theme gradient for bank cards preview
     */
    public function getCardGradientAttribute(): string
    {
        return match ($this->account_type) {
            'baridimob' => 'linear-gradient(135deg, #0d5f3a 0%, #10b981 100%)',
            'ccp' => 'linear-gradient(135deg, #926400 0%, #d97706 50%, #f59e0b 100%)',
            'bank' => 'linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%)',
            default => 'linear-gradient(135deg, #334155 0%, #475569 100%)',
        };
    }

    /**
     * Formatted display of account number or RIP
     */
    public function getDisplayNumberAttribute(): string
    {
        if (!empty($this->rip)) {
            // Group RIP into 4-digit chunks without trailing space
            return trim(chunk_split($this->rip, 4, ' '));
        }

        if (!empty($this->account_number)) {
            return $this->account_number;
        }

        return '—';
    }
}
