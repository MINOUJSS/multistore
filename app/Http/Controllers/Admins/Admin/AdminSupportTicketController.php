<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AdminSupportTicketController extends Controller
{
    /**
     * Display a listing of all platform support tickets.
     */
    public function index(Request $request)
    {
        $query = SupportTicket::with(['user', 'latestReply']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('user_email', 'like', "%{$search}%");
            });
        }

        $tickets = $query->orderBy('updated_at', 'desc')->paginate(12);

        $totalCount = SupportTicket::count();
        $openCount = SupportTicket::where('status', 'open')->count();
        $inProgressCount = SupportTicket::where('status', 'in_progress')->count();
        $answeredCount = SupportTicket::where('status', 'answered')->count();
        $closedCount = SupportTicket::where('status', 'closed')->count();

        return view('admins.admin.support_tickets.index', compact(
            'tickets',
            'totalCount',
            'openCount',
            'inProgressCount',
            'answeredCount',
            'closedCount'
        ));
    }

    /**
     * Display the specified support ticket and message thread.
     */
    public function show($id)
    {
        $ticket = SupportTicket::with(['user', 'replies', 'assignedAdmin'])->findOrFail($id);

        // Assign to current admin if unassigned
        if (is_null($ticket->assigned_admin_id)) {
            $ticket->update([
                'assigned_admin_id' => Auth::guard('admin')->id(),
            ]);
        }

        // Mark replies as read by admin
        SupportTicketReply::where('ticket_id', $ticket->id)
            ->where('sender_type', 'user')
            ->where('is_read_by_admin', false)
            ->update(['is_read_by_admin' => true]);

        return view('admins.admin.support_tickets.show', compact('ticket'));
    }

    /**
     * Admin reply to support ticket.
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:5120',
            'status' => 'nullable|string|in:open,in_progress,answered,closed',
        ]);

        $ticket = SupportTicket::findOrFail($id);
        $admin = Auth::guard('admin')->user();

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('support_tickets/admin_' . $admin->id, 'public');
                $attachments[] = 'storage/' . $path;
            }
        }

        $reply = SupportTicketReply::create([
            'ticket_id' => $ticket->id,
            'sender_type' => 'admin',
            'sender_id' => $admin->id,
            'sender_name' => $admin->name ?? 'فريق الدعم الفني',
            'message' => $request->message,
            'attachments' => $attachments,
            'is_read_by_user' => false,
            'is_read_by_admin' => true,
        ]);

        $newStatus = $request->status ?: 'answered';
        $updateData = [
            'status' => $newStatus,
            'assigned_admin_id' => $admin->id,
            'last_reply_at' => now(),
        ];

        if ($newStatus === 'closed') {
            $updateData['resolved_at'] = now();
        }

        $ticket->update($updateData);

        Alert::success('تم الرد بنجاح', 'تم إرسال ردك على التذكرة وتحديث حالتها بنجاح');

        return redirect()->back();
    }

    /**
     * Update ticket status or priority.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:open,in_progress,answered,closed',
            'priority' => 'nullable|string|in:low,medium,high,urgent',
        ]);

        $ticket = SupportTicket::findOrFail($id);
        $updateData = ['status' => $request->status];

        if ($request->filled('priority')) {
            $updateData['priority'] = $request->priority;
        }

        if ($request->status === 'closed') {
            $updateData['resolved_at'] = now();
        }

        $ticket->update($updateData);

        Alert::success('نجاح', 'تم تحديث حالة التذكرة بنجاح');

        return redirect()->back();
    }

    /**
     * Remove the specified support ticket.
     */
    public function destroy($id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticket->replies()->delete();
        $ticket->delete();

        Alert::success('نجاح', 'تم حذف تذكرة الدعم الفني بنجاح');

        return redirect()->route('admin.support_tickets.index');
    }
}
