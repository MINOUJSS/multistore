<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSellerCustomDomainAccess
{
    /**
     * Handle an incoming request.
     * Prevents sellers on the free plan from accessing custom domain features via URL.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the current seller has authorization for custom domain
        if (!is_seller_custom_domain_authorized()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ميزة الدومين المخصص غير متوفرة في الخطة المجانية، يرجى ترقية باقتك للاستفادة منها.',
                ], 403);
            }

            if (function_exists('alert')) {
                alert()->warning('تنبيه', 'ميزة الدومين المخصص غير متوفرة في الخطة المجانية، يرجى ترقية باقتك للاستفادة منها.');
            }

            return redirect()
                ->route('seller.subscription')
                ->with('error', 'ميزة الدومين المخصص غير متوفرة في الخطة المجانية، يرجى ترقية باقتك للاستفادة منها.');
        }

        return $next($request);
    }
}

