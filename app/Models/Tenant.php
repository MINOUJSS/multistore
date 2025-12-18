<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Domain;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    protected $fillable = [
        'id',
        'data',
    ];
    /**
     * Get the users of this tenant
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
    /**
     * Get the suppliers of this tenant
     */
    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }
    //
    // public function domain()
    // {
    //     return $this->belongsTo(Domain::class,'tenant_id');
    // }
}
