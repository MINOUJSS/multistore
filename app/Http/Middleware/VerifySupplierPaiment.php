<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Supplier\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier\SupplierPlanSubscription;
use Symfony\Component\HttpFoundation\Response;

class VerifySupplierPaiment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant_id=Auth::user()->tenant_id;
        $supplier=Supplier::where('tenant_id',$tenant_id)->first();
        $subscription=SupplierPlanSubscription::where('supplier_id',$supplier->id)->first();
        if($subscription->status == 'pending') 
        {
            return redirect()->route('supplier.subscription.confirmation');
        }
        return $next($request);
    }
}
