<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserSupportTicketController extends Controller
{
    /**
     * Display a listing of user support tickets.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = SupportTicket::where('user_id', $user->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query->orderBy('updated_at', 'desc')->paginate(10);
        $totalTicketsCount = SupportTicket::where('user_id', $user->id)->count();
        $openTicketsCount = SupportTicket::where('user_id', $user->id)->whereIn('status', ['open', 'in_progress'])->count();
        $answeredTicketsCount = SupportTicket::where('user_id', $user->id)->where('status', 'answered')->count();

        if($user->type == 'seller') {
            return view('users.sellers.support_tickets.index', compact(
                'tickets',
                'totalTicketsCount',
                'openTicketsCount',
                'answeredTicketsCount'
            ));
        }elseif($user->type == 'supplier') {
            return view('users.suppliers.support_tickets.index', compact(
                'tickets',
                'totalTicketsCount',
                'openTicketsCount',
                'answeredTicketsCount'
            ));
        }

    }

    /**
     * Store a newly created support ticket in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|in:technical,financial,shipping,general',
            'priority' => 'required|string|in:low,medium,high,urgent',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:5120',
        ]);

        $user = Auth::user();
        $ticketNumber = 'TK-' . strtoupper(substr(uniqid(), -6));

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('support_tickets/user_' . $user->id, 'public');
                $attachments[] = 'storage/' . $path;
            }
        }

        $ticket = SupportTicket::create([
            'ticket_number' => $ticketNumber,
            'user_id' => $user->id,
            'user_type' => $user->type ?: 'seller',
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->phone ?? null,
            'category' => $request->category,
            'priority' => $request->priority,
            'subject' => $request->subject,
            'message' => $request->message,
            'attachments' => $attachments,
            'status' => 'open',
            'last_reply_at' => now(),
        ]);

        // Create initial reply record
        SupportTicketReply::create([
            'ticket_id' => $ticket->id,
            'sender_type' => 'user',
            'sender_id' => $user->id,
            'sender_name' => $user->name,
            'message' => $request->message,
            'attachments' => $attachments,
            'is_read_by_user' => true,
            'is_read_by_admin' => false,
        ]);

        Alert::success('تم إنشاء التذكرة', 'تم تقديم تذكرة الدعم الفني بنجاح برقم: ' . $ticketNumber);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء تذكرة الدعم بنجاح',
                'ticket_number' => $ticketNumber,
                'redirect_url' => route('seller.support_tickets.show', $ticket->id),
            ]);
        }

        return redirect()->route('seller.support_tickets.show', $ticket->id);
    }

    /**
     * Display the specified support ticket and chat thread.
     */
    public function show($id)
    {
        $user = Auth::user();
        $ticket = SupportTicket::where('user_id', $user->id)->with('replies')->findOrFail($id);

        // Mark replies as read by user
        SupportTicketReply::where('ticket_id', $ticket->id)
            ->where('sender_type', 'admin')
            ->where('is_read_by_user', false)
            ->update(['is_read_by_user' => true]);

        return view('users.sellers.support_tickets.show', compact('ticket'));
    }

    /**
     * Store a reply to an existing support ticket.
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:5120',
        ]);

        $user = Auth::user();
        $ticket = SupportTicket::where('user_id', $user->id)->findOrFail($id);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('support_tickets/user_' . $user->id, 'public');
                $attachments[] = 'storage/' . $path;
            }
        }

        $reply = SupportTicketReply::create([
            'ticket_id' => $ticket->id,
            'sender_type' => 'user',
            'sender_id' => $user->id,
            'sender_name' => $user->name,
            'message' => $request->message,
            'attachments' => $attachments,
            'is_read_by_user' => true,
            'is_read_by_admin' => false,
        ]);

        $ticket->update([
            'status' => 'open',
            'last_reply_at' => now(),
        ]);

        Alert::success('تم إرسال الرد', 'تم إضافة ردك على تذكرة الدعم بنجاح');

        return redirect()->back();
    }

    /**
     * Close the specified support ticket.
     */
    public function close($id)
    {
        $user = Auth::user();
        $ticket = SupportTicket::where('user_id', $user->id)->findOrFail($id);

        $ticket->update([
            'status' => 'closed',
            'resolved_at' => now(),
        ]);

        Alert::success('تم إغلاق التذكرة', 'تم إغلاق تذكرة الدعم الفني بنجاح');

        return redirect()->back();
    }
}
