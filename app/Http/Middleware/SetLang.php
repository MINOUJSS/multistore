<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLang
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        // 1. Check if running under a Tenant Store context
        if (function_exists('tenant') && tenant('id')) {
            $tenantId = tenant('id');
            $sessionKey = 'store_locale_' . $tenantId;

            if (session()->has($sessionKey)) {
                $locale = session()->get($sessionKey);
            } else {
                try {
                    $langSetting = function_exists('get_user_store_settings')
                        ? get_user_store_settings($tenantId, 'store_language')
                        : null;
                    $locale = $langSetting?->value ?? 'ar';
                } catch (\Throwable $e) {
                    $locale = 'ar';
                }
            }

            if (in_array($locale, ['ar', 'fr', 'en'])) {
                app()->setLocale($locale);
            }
        } elseif (session()->has('locale')) {
            // 2. Central Platform / Standard Locale
            app()->setLocale(session()->get('locale'));
        }

        return $next($request);
    }
}
