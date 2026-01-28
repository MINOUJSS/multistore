<?php

namespace App\Http\Middleware;

use App\Models\Seller\Seller;
use App\Models\Seller\SellerPlanSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifySellerPaiment
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $tenant_id = Auth::user()->tenant_id;
        $seller = Seller::where('tenant_id', $tenant_id)->first();
        $subscription = SellerPlanSubscription::where('seller_id', $seller->id)->first();
        if ($subscription->status == 'pending') {
            return redirect()->route('seller.subscription.confirmation');
        }

        return $next($request);
    }
}
