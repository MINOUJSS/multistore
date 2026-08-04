---
name: chargily-payment
description: Handle Chargily Pay v2 webhook events, CIB/EDAHABIA checkout flows, and seller/supplier balance transactions.
---

# Chargily Payment Integration Skill (`chargily/chargily-pay`)

This skill defines instructions for handling online payments via Chargily Pay v2 (EDAHABIA and CIB Algerian bank cards) as well as internal user balances.

## Key Architecture Concepts
- **Package**: `chargily/chargily-pay` v2.0
- **Controller**: `App\Http\Controllers\ChargilyPayController.php`
- **Models**: `ChargilyPayment`, `ChargilyPaymentForTenants`, `ChargilySettingForTenants`, `UserBalance`, `BalanceTransaction`.

## Workflows & Instructions

### 1. Initiating Checkout Sessions
When creating a payment redirect for platform subscription or tenant customer checkout:
```php
use Chargily\ChargilyPay\ChargilyPay;
use Chargily\ChargilyPay\Auth\Credentials;

$chargily = new ChargilyPay(new Credentials([
    'mode' => config('chargily.mode', 'test'),
    'public_key' => $publicKey,
    'secret_key' => $secretKey,
]));

$checkout = $chargily->checkouts()->create([
    'metadata' => [
        'user_id' => $user->id,
        'payment_type' => 'subscription', // or 'tenant_order'
    ],
    'amount' => $amount,
    'currency' => 'dzd',
    'success_url' => route('chargily.success'),
    'failure_url' => route('chargily.failed'),
    'webhook_endpoint' => route('chargily.webhook'),
]);

return redirect($checkout->getUrl());
```

### 2. Handling Webhook Callbacks (`ChargilyPayController`)
- Webhooks MUST verify the HMAC signature provided by Chargily in headers before processing payloads.
- Verify status is `paid` before updating user subscriptions or balance ledgers.
- Always prevent duplicate processing by checking if the payment signature/transaction ID already exists in `ChargilyPayment`.

### 3. Ledger & Balance Updates
- When a payment is successful, record the credit transaction in `BalanceTransaction` and update `UserBalance`.
- Ensure transactions are wrapped in a database transaction (`DB::transaction(...)`) for atomic safety.
