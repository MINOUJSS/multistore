---
name: courierdz-shipping
description: Integration and troubleshooting for Algerian shipping couriers (Yalidine, ZrExpress, Mayastro, etc.) using piteurstudio/courierdz and CourierdzService.
---

# CourierDZ Shipping Integration Skill

This skill guides the implementation, management, and troubleshooting of shipping courier APIs for the Algerian market within `multi-store-ai`.

## Architecture Overview
- **Package**: `piteurstudio/courierdz`
- **Service Layer**: `App\Services\Users\CourierdzService.php`
- **Supported Couriers**: Yalidine, ZrExpress, Mayastro, Kazitour, EcoTrack, etc.
- **Data Models**: `ShippingCompaines`, `ShippingPrice`, `Wilaya`, `Dayra`, `Baladia`.

## Workflows & Instructions

### 1. Interacting via `CourierdzService`
Always use the central `CourierdzService` wrapper rather than making raw HTTP requests directly to shipping APIs:

```php
use App\Services\Users\CourierdzService;

$courierService = new CourierdzService();
// Create or track parcel using configured API keys for seller/supplier
```

### 2. Fetching Locations & Shipping Rates
- Wilaya, Dayra, and Baladia data are normalized across all Algerian couriers.
- Shipping fees depend on origin wilaya, destination wilaya, delivery type (Home vs Desk), and parcel weight.

### 3. Handling API Keys and Credentials
- Sellers and Suppliers store their courier API tokens in `UserStoreSetting` or `UserApps`.
- Never hardcode shipping tokens in source files or controllers.

### 4. Order Shipping Payload Guidelines
When sending an order to a courier:
- Mandatory fields: Receiver Name, Receiver Phone, Destination Wilaya ID, Destination Commune/Baladia, Order Price (COD amount), Product Description.
- Ensure proper error catching for API network timeouts or invalid phone formats (`05/06/07...`).
