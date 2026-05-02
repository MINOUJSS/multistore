<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Jobs\Admins\Admin\SendTelegramInfoAboutNewContactUs;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function store(Request $request)
    {
        if ($request->filled('website')) {
            abort(403); // spam bot
        }
        // validate
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:255',
        ]);

        $contact = new \App\Models\ContactMessage();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();

        // send telegrame notification to admin
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];
        // send telegram message to admin
        $job = SendTelegramInfoAboutNewContactUs::dispatch($data);

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال الرسالة بنجاح',
        ]);
    }
}
