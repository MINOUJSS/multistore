<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $parts = explode('.', request()->host());
        if ($parts[0] == 'supplier') {
            return $request->expectsJson() ? null : route('supplier.login');
        }

        return $request->expectsJson() ? null : route('seller.login');
    }
}
