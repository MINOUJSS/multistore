<?php

namespace App\Http\Controllers\Users\Suppliers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UsersPaymentsProofsRefused;
use App\Models\ProofsRefusedMessage; // Assuming this model exists
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SupplierProofsRefusedChatController extends Controller
{
    /**
     * Display the chat interface for a specific payment proof refusal.
     * This method might not be directly called if the chat UI is embedded.
     * It's more for context or if a dedicated chat page is needed.
     */
    public function index($proofId)
    {
        $proof = UsersPaymentsProofsRefused::findOrFail($proofId);
        // Ensure the current user is the owner of the proof or has access
        if ($proof->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        // Pass the proof to the view so it can access its ID for API calls
        return view('users.suppliers.components.content.proofs_refused.chat_box', compact('proof'));
    }

    /**
     * Get all messages for a specific payment proof refusal.
     * Used when the chat box is first opened.
     */
    public function getMessages($proofId)
    {
        $proof = UsersPaymentsProofsRefused::findOrFail($proofId);
        if ($proof->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $messages = ProofsRefusedMessage::where('payment_proof_id', $proofId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Format messages for the frontend
        $formattedMessages = $messages->map(function ($message) {
            return [
                'message' => $message->message,
                'sender_type' => $message->sender_type, // 'admin' or 'seller'
                'created_at' => $message->created_at->format('Y-m-d H:i'),
                // 'attachments' => $message->attachments ? json_decode($message->attachments) : [],
                'attachments' => $message->attachments ?? [],
            ];
        });

        return response()->json([
            'messages' => $formattedMessages,
            'unread_count' => 0, // This endpoint is for loading all, so unread count is 0 here
        ]);
    }

    /**
     * Fetch new messages since the last check.
     * Used for periodic polling.
     */
    public function fetchMessages($proofId)
    {
        $proof = UsersPaymentsProofsRefused::findOrFail($proofId);
        if ($proof->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        // Get the last message timestamp or count to determine new messages
        // For simplicity, let's fetch all messages and compare count with frontend lastMessageCount
        // A more efficient way would be to use timestamps or a 'read_at' column.
        $messages = ProofsRefusedMessage::where('payment_proof_id', $proofId)
            ->orderBy('created_at', 'asc')
            ->get();

        $formattedMessages = $messages->map(function ($message) {
            return [
                'message' => $message->message,
                'sender_type' => $message->sender_type, // 'admin' or 'seller'
                // 'created_at' => $message->created_at->format('Y-m-d H:i'),
                // 'attachments' => $message->attachments ? json_decode($message->attachments) : [],
                'attachments' => $message->attachments ?? [],
            ];
        });

        // Calculate unread count (assuming messages not sent by the current user are unread)
        $unreadCount = $messages->where('sender_type', 'admin')->where('is_read_by_seller', false)->count(); // Admin messages are unread for supplier

        return response()->json([
            'messages' => $formattedMessages,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Send a new message.
     */
    public function sendMessage(Request $request, $proofId)
    {
        $request->validate([
            'message' => 'nullable|string',
            'attachments.*' => 'nullable|file|max:20480', // Max 20MB per file
        ]);

        $proof = UsersPaymentsProofsRefused::findOrFail($proofId);
        if ($proof->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $messageText = $request->input('message');
        $attachments = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Store files in a tenant-specific directory if applicable, or a general storage path
                // Example: storage/app/public/proofs_refused_chat_attachments/{proofId}/{filename}
                // $path = $file->store("public/proofs_refused_chats/$proofId");
                // $attachments[] = str_replace('public/', '', $path);
                $path=Storage::disk('general')->put('proofs_refused_chats/'.$proofId.'/supplier', $file);
                $attachments[] = str_replace('public/', '', $path);
                // $attachments[] = 'app/public/'.$path;
                // $path = $file->store("proofs_refused_chat_attachments/{$proofId}", 'public');
                // if ($path) {
                //     $attachments[] = Storage::url($path); // Store the public URL
                // }
            }
        }

        $newMessage = ProofsRefusedMessage::create([
            'payment_proof_id' => $proofId,
            'message' => $messageText,
            'sender_type' => 'user', // This is the supplier sending the message
            'sender_id' => Auth::user()->id,
            'is_read_by_seller'=>true,
            'attachments' => json_encode($attachments),
        ]);

        return response()->json([
            'message' => $newMessage->message,
            'sender_type' => $newMessage->sender_type,
            'created_at' => $newMessage->created_at->format('Y-m-d H:i'),
            'attachments' => $attachments,
        ]);
    }

    /**
     * Mark all messages from the admin as read.
     */
    public function readMessages($proofId)
    {
        $proof = UsersPaymentsProofsRefused::findOrFail($proofId);
        if ($proof->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        // In a real scenario, you'd update a 'read_at' timestamp or a 'is_read' flag
        // For this example, we'll just acknowledge the request.
        // If we were marking messages, we'd do something like:
        ProofsRefusedMessage::where('payment_proof_id', $proofId)
            ->where('sender_type', 'admin')
            ->update(['is_read_by_seller' => true]); // Assuming an 'is_read' column

            return response()->json(['status' => 'ok']);
        // return response()->json(['success' => true, 'message' => 'Messages marked as read.']);
    }
}
