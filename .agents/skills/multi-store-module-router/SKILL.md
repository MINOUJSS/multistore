---
name: multi-store-module-router
description: Provide structured templates and instructions for extending features across role-segregated modules (Admin, Seller, Supplier, Tenant).
---

# Multi-Store Module Router Skill

This skill governs how new features, endpoints, controllers, and domain functions are registered across role modules in the `multi-store-ai` codebase.

## Directory & File Structure
```
routes/
└── modules/
    └── v1/
        ├── admin.php       # Platform Admin Routes
        ├── seller.php      # Seller API & Action Routes
        ├── web_seller.php  # Seller Web Interface Routes
        ├── supplier.php    # Wholesale Supplier Routes
        ├── tenant.php      # Customer Tenant Storefront Routes
        ├── marketer.php    # Affiliate / Marketer Routes
        ├── shiper.php      # Courier Operations Routes
        └── auth.php        # Authentication Routes
```

## Workflows & Instructions

### 1. Adding a New Route
When adding a feature for a specific role (e.g. Seller Product Management):
- Open the corresponding route file in `routes/modules/v1/seller.php` or `web_seller.php`.
- Group related routes with appropriate middleware and prefixes:
```php
Route::middleware(['auth:sanctum', 'role:seller'])->prefix('products')->name('seller.products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::post('/', [ProductController::class, 'store'])->name('store');
});
```

### 2. Creating Controllers & Services
- Place controllers in the corresponding role namespace:
  - Admin: `App\Http\Controllers\Admins\`
  - Seller: `App\Http\Controllers\Users\Seller\`
  - Supplier: `App\Http\Controllers\Users\Supplier\`
  - Tenant: `App\Http\Controllers\Tenants\`
- Keep controllers thin by creating services in `App\Services\Users\Sellers\` or `App\Services\Users\Suppliers\` for heavy logic.

### 3. Adding Domain Helper Functions
If writing reusable helper functions for a specific domain:
- Admin functions -> `app/Http/Functions/Admin/functions.php`
- Seller functions -> `app/Http/Functions/Seller/Functions.php`
- Supplier functions -> `app/Http/Functions/Supplier/functions.php`
- Do NOT declare duplicate function names; wrap declarations with `if (!function_exists('...'))`.
