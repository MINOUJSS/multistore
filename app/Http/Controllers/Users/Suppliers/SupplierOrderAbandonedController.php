<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Models\UserBalance;
use Illuminate\Http\Request;
use App\Models\BalanceTransaction;
use App\Http\Controllers\Controller;
use App\Models\SupplierOrderAbandoned;

class SupplierOrderAbandonedController extends Controller
{
    //
    public function index()
    {
        $orders=SupplierOrderAbandoned::OrderBy('id','desc')->where('supplier_id',get_supplier_data(auth()->user()->tenant_id)->id)->paginate(10);
        //make all orders readed
        foreach($orders as $order)
        {
            $order->is_readed=true;
            $order->update();
        }
        return view('users.suppliers.orders_abandoned.index',compact('orders'));
    }
    public function order($id)
    {
        $order = SupplierOrderAbandoned::with([
            'items.product',        // جلب معلومات المنتج
            'items.variation',  // جلب معلومات المتغير
            'items.attribute',  // جلب معلومات الخاصية
            'items.attribute.attribute'   // جلب معلومات الخاصية
        ])->findOrFail($id);
        //return $order;
        return response()->json($order);
    }
        //unlock phone number
        function unlock_phone_number($order_id)
        {
             //get user
             $user=auth()->user();
             //get user balance
             $user_balance=UserBalance::where('user_id',$user->id)->first();
             //check if user has a balanc
             $result=$user_balance->balance - $user_balance->outstanding_amount;
             if($result >=10 ){
            //update order phone visibility
            $order=SupplierOrderAbandoned::findOrFail($order_id);
            $order->phone_visiblity=true;
            $order->update();
            //add 10 d.a to user balance 
        
            //update user balance
            $balance=UserBalance::where('user_id',$user->id)->first();
            $balance->outstanding_amount=$balance->outstanding_amount+get_platform_comition($order->total_price);
            $balance->update();
             //commit this transaction in balance transaction table
             BalanceTransaction::create([
                'user_id' => $user->id,
                'transaction_type' => 'deduction',
                'amount' => get_platform_comition($order->total_price),
                'description' => 'مستحقات المنصة على الطلب رقم '.$order->id,
            ]);
            // إدراج الطلب في Google Sheets
            // $this->insertOrderToGoogleSheet($order);
         
            return response()->json([
                'message'=>'success'
            ]);

          }else
          {
            return response()->json([
                'status' => 'error',
                'message' => 'رصيدك غير كاف لفتح هذا الرقم،عليك بتعبئت رصيدك أولاً.',
            ]);
          }
        }
    //
     function delete_order($order_id)
     {
        $order=SupplierOrderAbandoned::findOrfail($order_id);
        $order->delete();
     } 
     //
     //
     public function filterOrders(Request $request)
    {
        $query = SupplierOrderAbandoned::query();

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                ->orWhere('customer_name', 'like', '%' . $request->search . '%');
            });
        }

        $orders = $query->where('supplier_id',get_supplier_data(auth()->user()->tenant_id)->id)->get();

        return view('users.suppliers.components.content.orders_abandoned.partials.orders_table', compact('orders'))->render();
    }
    //
    public function updateOrderStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:supplier_order_abandoneds,id',
            'status' => 'required|in:pending,processing,shipped,delivered,canceled'
        ]);

        $order = SupplierOrderAbandoned::findOrFail($request->order_id);
        $order->status = $request->status;
        $order->save();
        
        //update status in google sheet

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الحالة بنجاح',
            'status' => $order->status
        ]);
    }
}
