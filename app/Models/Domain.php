<?php

declare(strict_types=1);

namespace App\Models;

use Stancl\Tenancy\Database\Models\Domain as BaseDomain;

class Domain extends BaseDomain
{
    protected $fillable = [
        'domain',
        'tenant_id',
        'cloudflare_id',
        'status',
        'ssl_status',
        'verification_errors',
    ];

    /**
     * Check if this is a custom domain (not matching default platform host suffix).
     */
    public function isCustom(): bool
    {
        return !empty($this->cloudflare_id) || !str_ends_with($this->domain, '.dzora.net');
    }
}
