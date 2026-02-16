<?php

namespace App\Services\Users\Suppliers;

use App\Models\Seller\Seller;
use App\Models\Seller\SellerOrderItems;
use App\Models\Seller\SellerOrders;
use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierOrderItems;
use App\Models\Supplier\SupplierOrders;

class OrderNotificationService
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function sendOrderNotificationToSupplier(SupplierOrders $order)
    {
        // الحصول على بيانات المورد
        $supplier = Supplier::find($order->supplier_id);
        // dd($supplier);
        $user = get_user_data_from_supplier_id($supplier->id);
        $chat_ids = $user->telegrame_chat_id;
        $chat_id = json_decode($chat_ids[0]->data)->chat_id;

        if (!$supplier || !$chat_ids) {
            return false;
        }

        // بناء رسالة الطلب
        $message = $this->buildOrderMessage($order);

        // إرسال الرسالة عبر تيليغرام
        return $this->telegramService->sendMessage(
            $chat_id,
            $message
        );
    }

    protected function buildOrderMessage(SupplierOrders $order)
    {
        $items = SupplierOrderItems::where('order_id', $order->id)->with('product')->get();

        $message = "<b>🛒 طلب جديد #{$order->id}</b>\n";
        $message .= '📅 التاريخ: '.$order->created_at->format('Y-m-d H:i')."\n";
        $message .= "👤 العميل: {$order->customer_name}\n";
        if ($order->phone_visiblity == 1) {
            $message .= "📞 الهاتف: <a href='tel:{$order->phone}'>{$order->phone}</a>\n\n";
        } else {
            $message .= "📞 الهاتف: غير متوفر في الخطة المجانية\n\n";
        }
        $message .= "📦 المنتجات:\n";

        foreach ($items as $item) {
            $message .= "- {$item->product->name} (الكمية: {$item->quantity}, السعر: {$item->unit_price} دج)\n";
        }

        // الشحن
        $message .= "\n🚚 الشحن: <b>{$order->shipping_cost}</b>\n";
        $message .= "\n💸 الخصم: <b>{$order->discount}</b>\n";
        $message .= "\n💰 المجموع: <b>{$order->total_price} دج</b>\n";
        $message .= "📍 العنوان: {$order->shipping_address}\n";
        $message .= "<a href='supplier.".request()->server('HTTP_HOST').'/supplier-panel/orders'."'>🔗 قائمة الطلبات</a>\n";

        return $message;
    }

    // Sellers
    public function sendOrderNotificationToSeller(SellerOrders $order)
    {
        // الحصول على بيانات المورد
        $seller = Seller::find($order->seller_id);
        // dd($seller);
        $user = get_user_data_from_seller_id($seller->id);
        $chat_ids = $user->telegrame_chat_id;
        $chat_id = json_decode($chat_ids[0]->data)->chat_id;

        if (!$seller || !$chat_ids) {
            return false;
        }

        // بناء رسالة الطلب
        $message = $this->Seller_buildOrderMessage($order);

        // إرسال الرسالة عبر تيليغرام
        return $this->telegramService->sendMessage(
            $chat_id,
            $message
        );
    }

    protected function Seller_buildOrderMessage(SellerOrders $order)
    {
        $items = SellerOrderItems::where('order_id', $order->id)->with('product')->get();

        $message = "<b>🛒 طلب جديد #{$order->id}</b>\n";
        $message .= '📅 التاريخ: '.$order->created_at->format('Y-m-d H:i')."\n";
        $message .= "👤 العميل: {$order->customer_name}\n";
        if ($order->phone_visiblity == 1) {
            $message .= "📞 الهاتف: <a href='tel:{$order->phone}'>{$order->phone}</a>\n\n";
        } else {
            $message .= "📞 الهاتف: غير متوفر في الخطة المجانية\n\n";
        }
        $message .= "📦 المنتجات:\n";

        foreach ($items as $item) {
            $message .= "- {$item->product->name} (الكمية: {$item->quantity}, السعر: {$item->unit_price} دج)\n";
        }

        // الشحن
        $message .= "\n🚚 الشحن: <b>{$order->shipping_cost}</b>\n";
        $message .= "\n💸 الخصم: <b>{$order->discount}</b>\n";
        $message .= "\n💰 المجموع: <b>{$order->total_price} دج</b>\n";
        $message .= "📍 العنوان: {$order->shipping_address}\n";
        $message .= "<a href='".request()->server('HTTP_HOST').'/seller-panel/orders'."'>🔗 قائمة الطلبات</a>\n";

        return $message;
    }
}
