<?php

namespace App\Http\Middleware;

use App\Models\Seller\Seller;
use App\Models\Seller\SellerPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SellersRedirectSubscriber
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        // get user data
        $seller = Seller::where('tenant_id', Auth::user()->tenant_id)->first();
        // get paln data
        $plan = SellerPlan::where('id', $seller->plan_subscription->plan_id)->first();
        if ($seller->plan_subscription->payment_status == 'paid') {
            return redirect()->route('seller.dashboard')->with('redicect_subscriber', 'تم الدفع بنجاح مرحبا بك في الباقة: '.$plan->name);
        }

        return $next($request);
    }
}
