<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSellerOrSupplier
{
    /**
     * Handle an incoming request.
     * Ensure only registered sellers, suppliers, or admins can access.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow Platform Admins
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Allow authenticated users with 'seller' or 'supplier' role
        if (Auth::check()) {
            $userType = Auth::user()->type;
            if (in_array($userType, ['seller', 'supplier'])) {
                return $next($request);
            }
        }

        // Redirect unregistered or unauthorized visitors to the marketplace intro/gate page
        return redirect()->route('site.marketplace.suppliers.intro');
    }
}
