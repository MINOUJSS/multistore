<?php

namespace App\Http\Controllers\Admins\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProofsRefusedMessage;
use Illuminate\Support\Facades\Storage;

class ProofsRefusedChatController extends Controller
{
    // جلب الرسائل
    public function fetchMessages($paymentProofId)
    {
        $messages = ProofsRefusedMessage::where('payment_proof_id', $paymentProofId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'messages' => $messages,
            'unread_count' => $messages->where('is_read_by_admin', false)
                                        ->where('sender_type', 'user')
                                        ->count(),
        ]);
    }

    // إرسال رسالة
    public function sendMessage(Request $request, $paymentProofId)
    {
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $stored = admin_media_service()->storeFile($file, 'proofs_refused_chats/'.$paymentProofId.'/admin');
                $attachments[] = $stored['path'];
            }

        }

        $message = ProofsRefusedMessage::create([
            'payment_proof_id' => $paymentProofId,
            'sender_type' => 'admin',
            'sender_id' => auth('admin')->id() ?? null,
            'is_read_by_admin' => true,
            'message' => $request->message,
            'attachments' => json_encode($attachments),
        ]);

        return response()->json($message);
    }

    // تعليم الرسائل كمقروءة
    public function markAsRead($paymentProofId)
    {
        ProofsRefusedMessage::where('payment_proof_id', $paymentProofId)
            ->where('sender_type', 'user')
            ->update(['is_read_by_admin' => true]);

        return response()->json(['status' => 'ok']);
    }

    public function getMessages($id)
    {
        $messages = ProofsRefusedMessage::where('payment_proof_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'messages' => $messages,
            'id' => $id
        ]);
    }
}
