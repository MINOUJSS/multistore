<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'https://supplier.saouradelivery.com/supplier/chargilypay/webhook',
        'supplier/chargilypay/webhook',
        'chargilypay/webhook',
    ];
}
