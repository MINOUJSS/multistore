<?php

namespace App\Http\Middleware;

use App\Models\UserBlockedCustomers;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockFakeOrder
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $ip = $request->ip();
        $phone = $request->input('phone'); // يجب أن يكون حقل الهاتف موجود في الطلب
        $fingerprint = $request->input('device_fingerprint');

        // البحث عن العميل في قائمة الحظر
        $isBlocked = UserBlockedCustomers::where('status', 'active')
            ->where(function ($query) use ($ip, $phone, $fingerprint) {
                $query->where('ip_address', $ip)
                      ->orWhere('phone', $phone)
                      ->orWhere('device_fingerprint', $fingerprint);
            })
            ->exists();

        if ($isBlocked) {
            // ✅ إرجاع Response صحيح
            return response()->view('stores.suppliers.pages.block_page', [
                'message' => '🚫 تم حظرك من إتمام الطلبات بسبب نشاط مشبوه.',
            ], 403);
            // return response()->json([
            //     'message' => '🚫 تم حظرك من إتمام الطلبات بسبب نشاط مشبوه.',
            // ], 403);
        }

        return $next($request);
    }
}
