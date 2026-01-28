<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Seller\SellerOrders;
use App\Models\UserBlockedCustomers;

class SellerCustomerBlockListController extends Controller
{
    public function index()
    {
        return view('users.sellers.customer_block_list');
    }

    public function create($order_id)
    {
        // get ip address and device_fingerprint from order
        $order = SellerOrders::findOrfail($order_id);
        $ip_address = $order->ip_address;
        $device_fingerprint = $order->device_fingerprint;
        // check if the customer is already blocked
        // $order->customer_block_list->where('ip_address', $ip_address)->where('device_fingerprint', $device_fingerprint)->exists()
        $is_blocked = UserBlockedCustomers::where('ip_address', $ip_address)->where('device_fingerprint', $device_fingerprint)->exists();
        if ($is_blocked) {
            // delete blocked customer
            UserBlockedCustomers::where('user_id', auth()->user()->id)->where('ip_address', $ip_address)->where('device_fingerprint', $device_fingerprint)->delete();

            return response()->json([
                'success' => false,
                'status' => 'unblocked',
                'message' => 'The customer is already blocked',
            ]);
        } else {
            // create new blocked customer
            $block_list = UserBlockedCustomers::create([
                'user_id' => auth()->user()->id,
                'phone' => $order->phone,
                'ip_address' => $ip_address,
                'device_fingerprint' => $device_fingerprint,
                'reason' => 'تم الحظر من قبل المورد',
                'status' => 'active',
            ]);

            return response()->json([
                'success' => false,
                'status' => 'blocked',
                'message' => 'The customer is not blocked',
            ]);
        }

        return response()->json($order);
    }

    // is blocked function
    public function is_blocked($order_id)
    {
        $order = SellerOrders::findOrfail($order_id);
        $ip_address = $order->ip_address;
        $device_fingerprint = $order->device_fingerprint;
        $is_blocked = UserBlockedCustomers::where('ip_address', $ip_address)->where('device_fingerprint', $device_fingerprint)->exists();
        if ($is_blocked) {
            return response()->json([
                'success' => true,
                'status' => 'blocked',
                'message' => 'The customer is blocked',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'status' => 'unblocked',
                'message' => 'The customer is not blocked',
            ]);
        }
    }
}
