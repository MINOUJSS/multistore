---
name: multi-tenant-manager
description: Manage multi-tenant stores, domain mapping, tenant database migrations, and tenant-aware Livewire components using stancl/tenancy.
---

# Multi-Tenant Manager Skill (`stancl/tenancy`)

This skill provides operational workflows and coding patterns for managing multi-tenant functionality within the `multi-store-ai` platform.

## Key Architecture Concepts
- **Central Application**: Handles platform administration, user registration, seller/supplier dashboards, plan subscriptions, and global financial transactions.
- **Tenant Application**: Handles individual merchant storefronts running under unique subdomains or custom domains.
- **Tenant Database Isolation**: Each tenant store operates on its isolated database or scoped schema.

## Workflows & Instructions

### 1. Creating Tenant Migrations
When adding database fields or tables for tenant storefronts:
- Place migration files in `database/migrations/tenant/`.
- Do NOT run `php artisan migrate` for tenant changes; execute tenant migrations using:
  ```bash
  php artisan tenancy:migrate
  ```

### 2. Tenant Context Switching in Code
To execute logic within a specific tenant context programmatically:
```php
use App\Models\Tenant;

$tenant = Tenant::find($tenantId);
tenancy()->initialize($tenant);

// Logic executed here targets the tenant's isolated database/storage
// ...

tenancy()->end(); // Return to central context
```

### 3. Tenant Domain Mapping
- Tenant domains are managed via `App\Models\Tenant` and domain models.
- When creating a store for a seller, initialize the tenant model and attach their subdomain:
```php
$tenant = Tenant::create(['id' => $storeSlug, 'user_id' => $user->id]);
$tenant->domains()->create(['domain' => $storeSlug . '.' . config('tenancy.central_domains.0')]);
```

### 4. Tenant Livewire Components
- Livewire components mounted on tenant views must be placed in `app/Livewire/Tenants/`.
- Ensure components query tenant-scoped models and do not attempt cross-database joins with central tables directly without explicit connection switching.
