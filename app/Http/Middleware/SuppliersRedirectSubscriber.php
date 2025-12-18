<?php

namespace App\Http\Middleware;

use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuppliersRedirectSubscriber
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        // get user data
        $supplier = Supplier::where('tenant_id', Auth::user()->tenant_id)->first();
        // get paln data
        $plan = SupplierPlan::where('id', $supplier->plan_subscription->plan_id)->first();
        if ($supplier->plan_subscription->payment_status == 'paid') {
            return redirect()->route('supplier.dashboard')->with('redicect_subscriber', 'تم الدفع بنجاح مرحبا بك في الباقة: '.$plan->name);
        }

        return $next($request);
    }
}
