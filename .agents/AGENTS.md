# MULTI-STORE AI - WORKSPACE RULES

Adhere strictly to the project rules defined in [GEMINI.md](file:///c:/xampp/htdocs/projects/multi-store-ai/GEMINI.md):

1. **MVC Enforcement**: Business logic belongs exclusively in `Controllers` or `Services`. Never write business logic inside routes (`routes/modules/v1/*.php`) or Blade views.
2. **Migrations**: Database schema alterations must be done via Laravel Migrations (`database/migrations/` or `database/migrations/tenant/`).
3. **Modular Routes**: Maintain strict separation across domain routes: `admin.php`, `seller.php`, `supplier.php`, `tenant.php`, `marketer.php`.
4. **Helper Functions**: Place custom domain helpers in `app/Http/Functions/{Role}/functions.php`.
5. **Multi-Tenancy**: Respect `stancl/tenancy` context when working on Tenant vs Central features.
6. **Integrations**: Route shipping through `CourierdzService` and payment webhooks through `ChargilyPayController`.
