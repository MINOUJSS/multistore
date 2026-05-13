<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Admin\ContactUsMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(10);

        return view('admins.admin.contact_us_messages.index', compact('messages'));
    }

    public function show($id)
    {
        $message = ContactMessage::findorFail($id);

        return view('admins.admin.contact_us_messages.show', compact('message'));
    }

    public function reply($id)
    {
        // validation
        $validation = request()->validate([
            'reply' => 'required|string',
        ]);
        // get message
        $message = ContactMessage::findorFail($id);
        // create reply
        $reply = new \App\Models\ContactReply();
        $reply->contact_message_id = $message->id;
        $reply->admin_id = auth()->guard('admin')->user()->id;
        $reply->reply = $validation['reply'];
        $reply->save();
        // create email
        $to = $message->email;
        $subject = 'الرد على رسالتك بموضوع : "'.$message->subject.'"';
        $body = $validation['reply'];
        $data = [
            'name' => $message->name,
            'email' => $message->email,
            'subject' => $subject,
            'message' => $message->message,
            'reply' => $validation['reply'],
        ];
        // send reply email
        Mail::to($to)->queue(new ContactUsMail($data));
        // mark message as read
        $message->update(['is_read' => 1]);

        // redirect to show
        return redirect()->route('admin.contact.message.show', $id)->with('success', 'تم ارسال الرد بنجاح');
    }

    public function destroy($id)
    {
        $message = ContactMessage::findorFail($id);
        $message->delete();

        return response()->json(['message' => "Message with ID: {$id} deleted successfully"]);
        // return redirect()->route('admin.contact.messages')->with('success', 'تم حذف الرسالة بنجاح');
    }

    public function filter(Request $request)
    {
        $query = ContactMessage::query();

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('is_read', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('subject', 'LIKE', "%{$search}%")
                  ->orWhere('message', 'LIKE', "%{$search}%");
            });
        }

        $messages = $query
            ->latest()
            ->paginate(10);

        return view(
            'admins.admin.components.content.contact_us_messages.partials.messages_table',
            compact('messages')
        )->render();
    }

    // function ignore_reply
    public function ignore_reply($id)
    {
        $message = ContactMessage::findorFail($id);
        $message->update(['is_read' => 1]);

        return response()->json(['status' => 'success', 'message' => "Message with ID: {$id} marked as read successfully"]);
        // return redirect()->route('admin.contact.messages')->with('success', 'تم تجاهيز الرد بنجاح');
    }
}
