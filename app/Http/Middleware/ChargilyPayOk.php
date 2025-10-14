<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChargilyPayOk
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(is_supplier_aproved(tenant('id')) && is_chargily_settings_exists(tenant('id')))
        {
            return $next($request);
        }
        return redirect()->route('tenant.products');
    }
}
