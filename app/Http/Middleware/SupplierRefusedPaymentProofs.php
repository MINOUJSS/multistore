<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SupplierRefusedPaymentProofs
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        if (get_supplier_data(Auth::user()->tenant_id)->plan_subscription->plan_id == 3 && get_supplier_data(Auth::user()->tenant_id)->approval_status == 'approved' && Auth::user()->bank_settings != null) {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}
