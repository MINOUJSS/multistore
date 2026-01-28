<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\BalanceTransaction;
use App\Models\Seller\SellerOrderAbandoned;
use App\Models\Seller\SellerOrderItems;
use App\Models\Seller\SellerOrders;
use App\Models\UserBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerOrderAbandonedController extends Controller
{
    public function index()
    {
        $orders = SellerOrderAbandoned::OrderBy('id', 'desc')->where('seller_id', get_seller_data(auth()->user()->tenant_id)->id)->paginate(10);
        // make all orders readed
        foreach ($orders as $order) {
            $order->is_readed = true;
            $order->update();
        }

        return view('users.sellers.orders_abandoned.index', compact('orders'));
    }

    public function order($id)
    {
        $order = SellerOrderAbandoned::with([
            'items.product',        // جلب معلومات المنتج
            'items.variation',  // جلب معلومات المتغير
            'items.attribute',  // جلب معلومات الخاصية
            'items.attribute.attribute',   // جلب معلومات الخاصية
        ])->findOrFail($id);

        // return $order;
        return response()->json($order);
    }

    // unlock phone number
    public function unlock_phone_number($order_id)
    {
        // get user
        $user = auth()->user();
        // get user balance
        $user_balance = UserBalance::where('user_id', $user->id)->first();
        // check if user has a balanc
        $result = $user_balance->balance - $user_balance->outstanding_amount;
        if ($result >= 10) {
            // update order phone visibility
            $order = SellerOrderAbandoned::findOrFail($order_id);
            $order->phone_visiblity = true;
            $order->update();
            // add 10 d.a to user balance

            // update user balance
            $balance = UserBalance::where('user_id', $user->id)->first();
            $balance->outstanding_amount = $balance->outstanding_amount + get_order_abandoned_comition(get_seller_data(auth()->user()->tenant_id)->plan_subscription->plan_id);
            $balance->update();
            // commit this transaction in balance transaction table
            BalanceTransaction::create([
                'user_id' => $user->id,
                'transaction_type' => 'deduction',
                'amount' => get_platform_comition($order->total_price),
                'description' => 'مستحقات المنصة على الطلب رقم '.$order->id,
            ]);
            // إدراج الطلب في Google Sheets
            // $this->insertOrderToGoogleSheet($order);

            return response()->json([
                'message' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'رصيدك غير كاف لفتح هذا الرقم،عليك بتعبئت رصيدك أولاً.',
            ]);
        }
    }

    public function delete_order($order_id)
    {
        $order = SellerOrderAbandoned::findOrfail($order_id);
        $order->delete();
    }

    public function filterOrders(Request $request)
    {
        $query = SellerOrderAbandoned::query();

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%'.$request->search.'%')
                ->orWhere('customer_name', 'like', '%'.$request->search.'%');
            });
        }

        $orders = $query->where('seller_id', get_seller_data(auth()->user()->tenant_id)->id)->get();

        return view('users.sellers.components.content.orders_abandoned.partials.orders_table', compact('orders'))->render();
    }

    public function updateOrderStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:seller_order_abandoneds,id',
            'status' => 'required|in:pending,processing,shipped,delivered,canceled',
        ]);

        $order = SellerOrderAbandoned::findOrFail($request->order_id);
        $order->status = $request->status;
        $order->save();

        // update status in google sheet

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الحالة بنجاح',
            'status' => $order->status,
        ]);
    }

    public function decreaseStock($orderItem)
    {
        $product = $orderItem->product;

        // نقص من الكمية الكلية
        $product->decrement('qty', $orderItem->quantity);
        // إذا فيه variation
        if ($orderItem->variation_id != null) {
            $variation = $orderItem->variation;
            $variation->decrement('stock_quantity', $orderItem->quantity);
        }
        // إذا فيه attribute
        if ($orderItem->attribute_id != null) {
            $attribute = $orderItem->attribute;
            $attribute->decrement('stock_quantity', $orderItem->quantity);
        }
    }

    // move to order
    public function move_to_order(Request $request)
    {
        $abandoned_order = SellerOrderAbandoned::findOrFail($request->order_id);
        // ctreate new order
        // return response()->json([
        //     'message' => 'success',
        //     'abandoned_order' =>$abandoned_order->billing_address,
        // ]);

        DB::beginTransaction();
        try {
            $sellerOrder = SellerOrders::create([
                'seller_id' => $abandoned_order->seller_id,
                'order_number' => 'ORD-'.strtoupper(uniqid()),
                'customer_name' => $abandoned_order->customer_name,
                'phone' => $abandoned_order->phone,
                'phone_visiblity' => $abandoned_order->phone_visiblity,
                'status' => 'pending',
                'total_price' => $abandoned_order->total_price,
                'discount' => 0.00,
                'shipping_cost' => $abandoned_order->shipping_cost,
                'shipping_type' => 'to_home',
                'free_shipping' => 'no',
                'payment_method' => $abandoned_order->payment_method,
                'payment_status' => 'pending',
                'note' => $abandoned_order->note,
                'shipping_address' => $abandoned_order->shipping_address,
                'billing_address' => $abandoned_order->billing_address ?? $abandoned_order->shipping_address,
                'wilaya_id' => 1,
                'dayra_id' => null,
                'baladia_id' => null,
            ]);

            // return response()->json([
            //     'message' => 'success',
            //     'abandoned_order' => $sellerOrder,
            // ]);

            // إدراج عنصر الطلب
            foreach ($abandoned_order->items as $item) {
                $order_item = SellerOrderItems::create([
                    'order_id' => $sellerOrder->id,
                    'product_id' => $item->product_id,
                    'variation_id' => $item->variation_id,
                    'attribute_id' => $item->attribute_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                ]);
                // إدارة المخزون
                $this->decreaseStock($order_item);
            }

            $abandoned_order->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'تم حفظ الطلب بنجاح',
                'order_id' => $sellerOrder->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ ما، يرجى المحاولة مرة أخرى',
            ]);
        }
    }
}
