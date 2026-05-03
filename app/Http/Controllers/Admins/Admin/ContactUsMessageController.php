<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Admin\ContactUsMail;
use App\Models\ContactMessage;
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
}
