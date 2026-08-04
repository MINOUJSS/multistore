# MULTI-STORE AI - ARCHITECTURAL & CODING GUIDELINES (GEMINI.md)

## 1. PROJECT OVERVIEW & TECH STACK
`Multi-Store AI` is a multi-tenant e-commerce platform built for multi-vendor SaaS operations, supporting tenant stores, wholesale suppliers, sellers, and platform administrators.

- **Backend Framework**: Laravel 10 (PHP 8.1+)
- **Multi-Tenancy**: `stancl/tenancy` v3.8 (Subdomain & Database Isolation)
- **Frontend Stack**: Livewire 3, Blade Templating, Bootstrap / Tailwind CSS, Vanilla JS
- **Payment Gateway Integrations**: `chargily/chargily-pay` v2 (Algerian CIB/EDAHABIA), PayPal, Stripe
- **Shipping Courier Integration**: `piteurstudio/courierdz` via `CourierdzService` (Yalidine, ZrExpress, Mayastro, etc.)
- **Media & Assets**: `spatie/laravel-medialibrary` v11, `carlos-meneses/laravel-mpdf`

---

## 2. STRICT ARCHITECTURAL BOUNDARIES & RULES

### 🚨 RULE 1: STRICT MVC SEPARATION
- **Controllers & Services**: ALL business logic, data calculations, external API calls, and domain rules MUST reside inside Controller classes (`app/Http/Controllers/`) or dedicated Service classes (`app/Services/`).
- **Routes**: Route files inside `routes/modules/v1/` MUST ONLY map HTTP endpoints to Controller methods. NEVER write closures or inline business logic inside routes.
- **Blade Views & Livewire Components**: Views must strictly focus on presentation. Do NOT write complex SQL queries or heavy data transformations inside `.blade.php` files or Livewire render methods.

### 🚨 RULE 2: DATABASE INTEGRITY & MIGRATIONS
- **NEVER** alter the database schema directly via SQL clients or manual modifications.
- **ALWAYS** write and execute standard Laravel Migration files (`database/migrations/` for central DB, or `database/migrations/tenant/` for tenant DBs).
- **ALWAYS** use Eloquent ORM or Query Builder for data access to protect against SQL Injection.

### 🚨 RULE 3: DOMAIN PARTITIONING & MODULAR ROUTING
The application is partitioned into 5 distinct domains. Maintain strict isolation between their controllers, models, and routes:
1. **Admin Platform** (`routes/modules/v1/admin.php`, `app/Http/Controllers/Admins/`)
2. **Seller Store Management** (`routes/modules/v1/seller.php`, `routes/modules/v1/web_seller.php`, `app/Http/Controllers/Users/Seller/`)
3. **Wholesale Supplier** (`routes/modules/v1/supplier.php`, `app/Http/Controllers/Users/Supplier/`)
4. **Tenant Store Customer View** (`routes/modules/v1/tenant.php`, `app/Http/Controllers/Tenants/`)
5. **Marketer / Affiliate** (`routes/modules/v1/marketer.php`)

### 🚨 RULE 4: DOMAIN HELPER FUNCTIONS
Custom helper functions are grouped by domain and registered in `composer.json`. Place new helper functions in the appropriate domain file:
- Admin: `app/Http/Functions/Admin/functions.php`
- Seller: `app/Http/Functions/Seller/Functions.php`
- Supplier: `app/Http/Functions/Supplier/functions.php`
- Affiliate: `app/Http/Functions/Affiliate/functions.php`
- Users: `app/Http/Functions/Users/functions.php`
- Platform: `app/Http/Functions/Platform/functions.php`

---

## 3. MULTI-TENANCY PROTOCOLS (`stancl/tenancy`)

- **Central vs Tenant Context**:
  - Central routes handle registration, platform admin, seller dashboards, and billing.
  - Tenant routes handle individual storefronts running on subdomains or custom domains.
- **Tenant Database Migrations**:
  - Tenant-specific schema changes must be placed in `database/migrations/tenant/`.
  - Run tenant migrations using `php artisan tenancy:migrate`.
- **Tenant Livewire Components**:
  - Ensure Livewire components operating under tenant subdomains respect tenant scope and avoid leaking central data.

---

## 4. INTEGRATION STANDARDS

### A. Courier Shipping (`CourierdzService`)
- All interaction with shipping providers (Yalidine, ZrExpress, Mayastro, etc.) MUST pass through `App\Services\Users\CourierdzService.php` or the `piteurstudio/courierdz` package wrappers.
- Do NOT hardcode API credentials; retrieve them dynamically from `UserStoreSetting` or `.env`.

### B. Payment Gateways (`ChargilyPayController`)
- Webhook endpoints for Chargily Pay v2 must validate signatures and correctly distinguish between Central platform subscriptions and Tenant customer checkout payments (`ChargilyPayment` vs `ChargilyPaymentForTenants`).
- Balance updates for Sellers/Suppliers MUST be logged inside `BalanceTransaction` or `FinancialLedger` models.

---

## 5. SECURITY & CODE QUALITY

- **CSRF Protection**: All HTML forms must include `@csrf`. AJAX calls must send the `X-CSRF-TOKEN` header.
- **Validation**: Use Laravel `FormRequest` classes or `$request->validate([...])` for all incoming user input.
- **Error Handling**: Use SweetAlert (`realrashid/sweet-alert`) for user-facing notifications and proper exception logging for background tasks.
- **File Uploads**: Use Spatie MediaLibrary or `TempUploadController` for file uploads; sanitize filenames and restrict executable extensions.
