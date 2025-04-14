<?php

namespace App\Http\Controllers\Users\Suppliers;

use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;
use App\Models\UserBalance;
use Illuminate\Http\Request;
use App\Models\SupplierOrders;
use App\Models\BalanceTransaction;
use App\Http\Controllers\Controller;

class SupplierOrderController extends Controller
{
    //
    public function index()
    {
        $orders=SupplierOrders::OrderBy('id','desc')->where('supplier_id',get_supplier_data(auth()->user()->tenant_id)->id)->paginate(10);
        //make all orders readed
        foreach($orders as $order)
        {
            if($order->is_readed==false)
            {
            $order->is_readed=true;
            $order->update();
            }
        }
        return view('users.suppliers.orders.index',compact('orders'));
    }
    //
    public function order($id)
    {
        $order = SupplierOrders::with([
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
            $order=SupplierOrders::findOrFail($order_id);
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
            $this->insertOrderToGoogleSheet($order);
         
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
        $order=SupplierOrders::findOrfail($order_id);
        $order->delete();
     } 
     //
     public function filterOrders(Request $request)
    {
        $query = SupplierOrders::query();

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

        return view('users.suppliers.components.content.orders.partials.orders_table', compact('orders'))->render();
    }

    //
    public function updateOrderStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:supplier_orders,id',
            'status' => 'required|in:pending,processing,shipped,delivered,canceled'
        ]);

        $order = SupplierOrders::findOrFail($request->order_id);
        $order->status = $request->status;
        $order->save();
        
        //update status in google sheet

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الحالة بنجاح',
            'status' => $order->status
        ]);
    }


        /**
     * إدراج الطلب في Google Sheets عبر Webhook
     */
    private function insertOrderToGoogleSheet($order)
    {
        try {
            $spreadsheetId = "1XOfN-5TI0LBDRFefQLemlkOjyCVTaF8jqwLt7wIbr9Y"; // Google Sheet ID
            $range = "Orders"; // اسم الورقة داخل الملف
    
            $client = new Google_Client();
            $client->setApplicationName("Google Sheets API Laravel");
            $client->setAuthConfig(base_path('/asset/googleSheet/credentials.json')); 
            $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
    
            $service = new Google_Service_Sheets($client);
    
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
                    $order->status ?? 'Pending'
                ]
            ];
    
            $body = new Google_Service_Sheets_ValueRange([
                'values' => $values
            ]);
    
            $params = ['valueInputOption' => 'RAW'];
    
            $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
    
        } catch (\Exception $e) {
            \Log::error("Error inserting order to Google Sheets: " . $e->getMessage());
        }
    }
}
