<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VermentPayOk
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //gte user type
        $user_type = get_user_data(tenant('id'))->type;
        if($user_type =='supplier')
            {
                if(is_supplier_aproved(tenant('id')) && is_verment_settings_exists(tenant('id')))
                {
                    return $next($request);
                }
            }else
            {
            if(is_seller_aproved(tenant('id')) && is_verment_settings_exists(tenant('id')))
                {
                    return $next($request);
                }
            }
        
        return redirect()->route('tenant.products');
    }
}
