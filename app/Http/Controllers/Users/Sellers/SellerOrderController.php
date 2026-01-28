<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Jobs\Users\Suppliers\sendOrderDataToGoogleSheet;
use App\Models\Admin;
use App\Models\BalanceTransaction;
use App\Models\Seller\SellerOrderItems;
use App\Models\Seller\SellerOrders;
use App\Models\Seller\SellerProducts;
use App\Models\ShippingCompaines;
use App\Models\UserBalance;
use App\Models\UsersPaymentsProofsRefused;
use App\Models\Wilaya;
use App\Notifications\Users\Suppliers\PaymentRejected;
use App\Services\Users\CourierdzService;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function index()
    {
        // $courierdz = new CourierdzService(1, auth()->user()->type, 'YALIDINE');
        // dd($courierdz->test_yalidine('yal-V23CBN'));
        $orders = SellerOrders::OrderBy('id', 'desc')->where('seller_id', get_seller_data(auth()->user()->tenant_id)->id)->paginate(10);
        // make all orders readed
        foreach ($orders as $order) {
            if ($order->is_readed == false) {
                $order->is_readed = true;
                $order->update();
            }
        }
        // get shipping companies
        $companies = ShippingCompaines::where('user_id', auth()->user()->id)->where('status', 'active')->get();

        return view('users.sellers.orders.index', compact('orders', 'companies'));
    }

    public function order($id)
    {
        $order = SellerOrders::with([
            'items.product',        // جلب معلومات المنتج
            'items.product.activediscount',        // جلب معلومات المنتج
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
            $order = SellerOrders::findOrFail($order_id);
            $order->phone_visiblity = true;
            $order->update();
            // add 10 d.a to user balance

            // update user balance
            $balance = UserBalance::where('user_id', $user->id)->first();
            $balance->outstanding_amount = $balance->outstanding_amount + get_platform_comition($order->total_price);
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
            // جعل الإشتراك قديم
            $seller = get_seller_data($user->tenant_id);
            $seller_subscription = $seller->plan_subscription;
            $seller_subscription->change_subscription = 1;
            $seller_subscription->update();

            // رسالة للمستخدم بعدم كفاية الرصيد
            return response()->json([
                'status' => 'error',
                'message' => 'رصيدك غير كاف لفتح هذا الرقم،عليك بتعبئت رصيدك أولاً.',
            ]);
        }
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

    public function restoreStock($orderItem)
    {
        $product = $orderItem->product;

        // إعادة الكمية للمنتج الكلي
        $product->increment('qty', $orderItem->quantity);

        // إعادة الكمية للـ variation إذا وجد
        if ($orderItem->variation_id != null) {
            $variation = $orderItem->variation;
            $variation->increment('stock_quantity', $orderItem->quantity);
        }

        // إعادة الكمية للـ attribute إذا وجد
        if ($orderItem->attribute_id != null) {
            $attribute = $orderItem->attribute;
            $attribute->increment('stock_quantity', $orderItem->quantity);
        }
    }

    public function delete_order($order_id)
    {
        $order = SellerOrders::findOrfail($order_id);
        $order_items = SellerOrderItems::where('order_id', $order_id)->get();
        foreach ($order_items as $order_item) {
            $this->restoreStock($order_item);
        }
        $order->delete();
    }

    public function filterOrders(Request $request)
    {
        $query = SellerOrders::query();

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%'.$request->search.'%')
                ->orWhere('customer_name', 'like', '%'.$request->search.'%')
                ->orWhere('phone', 'like', '%'.$request->search.'%');
            });
        }

        $orders = $query->where('seller_id', get_seller_data(auth()->user()->tenant_id)->id)->get();

        return view('users.sellers.components.content.orders.partials.orders_table', compact('orders'))->render();
    }

    public function updateOrderStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:seller_orders,id',
            'status' => 'required|in:pending,processing,shipped,delivered,canceled',
        ]);

        $order = SellerOrders::findOrFail($request->order_id);
        $old_status = $order->status;
        $new_status = $request->status;
        $order->status = $request->status;
        $order->save();

        // إدارة المخزون
        if ($new_status === 'canceled') {
            foreach ($order->items as $item) {
                $this->restoreStock($item);
            }
        }

        if (($new_status === 'pending' || $new_status === 'processing' || $new_status === 'shipped' || $new_status === 'delivered') && $old_status === 'canceled') {
            foreach ($order->items as $item) {
                $this->decreaseStock($item);
            }
        }
        // إدراج الطلب في Google Sheets
        if ($new_status === 'shipped' && $order->phone_visiblity) {
            sendOrderDataToGoogleSheet::dispatch(auth()->user()->tenant_id, $order);
        }

        // update status in google sheet

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الحالة بنجاح',
            'status' => $order->status,
        ]);
    }

    /**
     * إدراج الطلب في Google Sheets عبر Webhook.
     */
    private function insertOrderToGoogleSheet($order)
    {
        try {
            // 1XUsNfu5kCBXSjoOWRIycyPntiL_Gand2zOj7QbbAKsM
            // 1XOfN-5TI0LBDRFefQLemlkOjyCVTaF8jqwLt7wIbr9Y
            $spreadsheetId = '1XUsNfu5kCBXSjoOWRIycyPntiL_Gand2zOj7QbbAKsM'; // Google Sheet ID
            $range = 'Orders'; // اسم الورقة داخل الملف

            $client = new \Google_Client();
            $client->setApplicationName('Google Sheets API Laravel');
            $client->setAuthConfig(base_path('/asset/googleSheet/credentials.json'));
            $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

            $service = new \Google_Service_Sheets($client);

            $values = [
                [
                    now()->format('Y-m-d H:i:s'), // الوقت الحالي
                    $order->order_number ?? 'N/A',
                    $order->customer_name ?? 'N/A',
                    $order->phone ?? 'N/A',
                    $order->shipping_address ?? 'N/A',
                    $order->total_price ?? 0,
                    $order->shipping_cost ?? 0,
                    $order->payment_method ?? 'Unknown',
                    $order->status ?? 'Pending',
                ],
            ];

            $body = new \Google_Service_Sheets_ValueRange([
                'values' => $values,
            ]);

            $params = ['valueInputOption' => 'RAW'];

            $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
        } catch (\Exception $e) {
            \Log::error('Error inserting order to Google Sheets: '.$e->getMessage());
        }
    }

    // delete order item from order
    public function order_item_delete($order_item_id)
    {
        $order_item = SellerOrderItems::findOrfail($order_item_id);
        // get order
        $order = SellerOrders::findOrfail($order_item->order_id);
        if (count($order->items) > 1) {
            // delete order item price from order total price
            $order->total_price -= $order_item->unit_price * $order_item->quantity;
            $order->update();
            $order_item->delete();
        }
    }

    // edit
    public function edit_order($id)
    {
        // $order = SellerOrders::findOrfail($order_id);
        // جلب الطلب مع العناصر والمنتجات المرتبطة
        $order = SellerOrders::with([
            'items.product', // المنتج
            'items.variation', // الاختلافات إن وجدت
            'items.attribute', // الخصائص إن وجدت
        ])->findOrFail($id);

        // التحقق من أن المستخدم مخول بالتعديل (يمكن عمل ميدلوير لهذا)
        if (
            $order->confirmation_status === 'confirmed'
            && !(
                auth()->user()->id === $order->confirmed_by_user_id // المورد نفسه
                || auth()->user()->employee && auth()->user()->employee->id === $order->confirmed_by_employee_id // الموظف الذي أكد
            )
        ) {
            return response()->json(['message' => 'غير مسموح لك بتعديل هذه الطلبية.'], 403);
        }
        // تحديد المسؤول عن التعديل
        if (auth('web')->check()) {
            // المورد
            $order->confirmed_by_user_id = auth('web')->id();
        } elseif (auth('employee')->check()) {
            // الموظف
            $order->confirmed_by_employee_id = auth('employee')->id();
        }
        $order->save();

        // جلب قائمة المنتجات (إذا أردت السماح بتعديل المنتج في الطلب)
        // $products = SellerProducts::pluck('name', 'id');
        $products = SellerProducts::all();
        $wilayas = Wilaya::all();

        return view('users.sellers.orders.edit_order', compact('order', 'products', 'wilayas'));
    }

    // update
    public function update_order(Request $request, $id)
    {
        $order = SellerOrders::with('items')->findOrFail($id);

        // ✅ 1) تحديث بيانات الطلب
        $order->update([
            'customer_name' => $request->customer_name,
            'confirmation_status' => $request->confirmation_status,
            'status' => $request->status,
            'total_price' => $request->total_price,
            'discount' => $request->discount,
            'shipping_cost' => $request->shipping_cost,
            'note' => $request->note,
        ]);

        // ✅ 2) تحديث العناصر الموجودة
        if ($request->has('items')) {
            foreach ($request->items as $itemId => $data) {
                $item = SellerOrderItems::find($itemId);
                if ($item) {
                    $item->update([
                        'variation_id' => $data['variation_id'] ?? null,
                        'attribute_id' => $data['attribute_id'] ?? null,
                        'quantity' => $data['quantity'],
                        'unit_price' => $data['unit_price'],
                        'total_price' => $data['quantity'] * $data['unit_price'],
                    ]);
                }
            }
        }

        // ✅ 3) إضافة عناصر جديدة
        if ($request->has('new_items')) {
            foreach ($request->new_items as $productId => $data) {
                SellerOrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'variation_id' => $data['variation_id'] ?? null,
                    'attribute_id' => $data['attribute_id'] ?? null,
                    'quantity' => $data['quantity'],
                    'unit_price' => $data['unit_price'],
                    'total_price' => $data['quantity'] * $data['unit_price'],
                ]);
            }
        }

        // ✅ 4) حذف العناصر التي تم إزالتها من الفورم
        $existingItemIds = $order->items->pluck('id')->toArray();
        $submittedItemIds = $request->has('items') ? array_keys($request->items) : [];
        $deletedItemIds = array_diff($existingItemIds, $submittedItemIds);

        if (!empty($deletedItemIds)) {
            SellerOrderItems::whereIn('id', $deletedItemIds)->delete();
        }

        return response()->json(['success' => true]);

        // return redirect()->route('seller.order.edit', $order->id)
        //                  ->with('success', 'تم تحديث الطلب بنجاح.');

        // return redirect()->route('seller.orders.index')->with('success', 'تم تحديث الطلب بنجاح');
    }

    public function deleteItem($id)
    {
        $item = SellerOrderItems::findOrFail($id);
        // $item->delete();
        // get order
        $order = SellerOrders::findOrfail($item->order_id);
        if (count($order->items) > 1) {
            // delete order item price from order total price
            $order->total_price -= $item->unit_price * $item->quantity;
            $order->update();
            $item->delete();
        }

        return response()->json(['success' => true]);
    }

    // traking order
    public function tracking_order($order_id)
    {
        $order = SellerOrders::with([
            'items.product',        // جلب معلومات المنتج
            'items.product.activediscount',        // جلب معلومات المنتج
            'items.variation',  // جلب معلومات المتغير
            'items.attribute',  // جلب معلومات الخاصية
            'items.attribute.attribute',   // جلب معلومات الخاصية
        ])->findOrFail($order_id);
        // get shipping company
        $company = $order->shipping_company;
        // get tracking number
        $tracking_number = $order->shipping_tracking_number;

        $courierdz = new CourierdzService($order_id, auth()->user()->type, $company);

        if ($company == 'YALIDINE') {
            $response = $courierdz->getParcelDetails($order->shipping_tracking_number);
        }
        if ($response == null) {
            return response()->json([
                'success' => false,
                'data' => $response,
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => $response,
            ]);
        }
        // return view('users.sellers.orders.track_order', compact('order'));
    }

    // delete tracking order

    public function delete_tracking_order($order_id)
    {
        $order = SellerOrders::findOrFail($order_id);
        // get company name and tracking number
        $company = $order->shipping_company;
        $tracking_id = $order->shipping_tracking_number;
        // update order in data base
        $order->shipping_company = null;
        $order->shipping_tracking_number = null;
        $order->update();

        $courierdz = new CourierdzService($order_id, auth()->user()->type, $company);

        if ($company == 'YALIDINE') {
            $response = $courierdz->delete_yalidine_order($tracking_id);
        } elseif ($company == 'DHD') {
            $response = $courierdz->delete_dhd_order($tracking_id);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الطلب بنجاح',
            'data' => $response,
        ]);
    }

    public function updateConfirmationStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:seller_orders,id',
            'confirmation_status' => 'required|string|in:pending,call1,call2,call3,error_phone,no_answer,confirmed',
        ]);

        $order = SellerOrders::findOrFail($request->order_id);
        $order->confirmation_status = $request->confirmation_status;
        $order->confirmed_by_user_id = auth()->user()->id; // من قام بالتأكيد (صاحب الحساب)

        if ($request->confirmation_status === 'confirmed') {
            $order->status = 'processing';
            $order->confirmed_at = now();
        } elseif ($request->confirmation_status === 'error_phone') {
            $order->status = 'canceled';
            $order->confirmed_at = now();
        } else {
            $order->status = 'pending';
            $order->confirmed_at = now();
        }

        $order->save();

        return response()->json(['success' => true]);
    }

    public function acceptPayment(SellerOrders $order)
    {
        $order->update([
            'payment_status' => 'paid',
            'payment_method' => 'verments',
            'confirmation_status' => 'confirmed',
            'confirmed_by_user_id' => auth()->user()->id,
            'confirmed_at' => now(),
            'status' => 'processing',
        ]);

        return response()->json(['message' => 'تم قبول الدفع']);
    }

    public function rejectPayment(SellerOrders $order)
    {
        $order->update([
            'payment_status' => 'failed',
            'status' => 'canceled',
        ]);
        // insert this refuse to payment proof refused table
        UsersPaymentsProofsRefused::create([
            'order_number' => $order->order_number,
            'user_id' => get_user_data(get_seller_data_from_id($order->seller_id)->tenant_id)->id,
            'proof_path' => $order->payment_proof,
            'refuse_reason' => 'تم رفض الدفع من طرف البائع',
        ]);
        // إرسال إشعار لكل من له صلاحية "admin" أو "financial_manager"
        $admins = Admin::whereIn('type', ['admin', 'financial_manager'])->get();

        foreach ($admins as $admin) {
            $admin->notify(new PaymentRejected($order));
        }

        return response()->json(['message' => 'تم رفض الدفع']);
    }
}
