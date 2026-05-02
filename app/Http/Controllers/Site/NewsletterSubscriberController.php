<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Jobs\Admins\Admin\SendTelegramInfoAboutNewNewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        if ($request->filled('website')) {
            abort(403); // spam bot
        }
        $data = $request->validate([
            'subscriber_email' => 'required|email',
        ]);

        // check if email already exists
        $subscriber = \App\Models\NewsletterSubscriber::where('email', $data['subscriber_email'])->first();
        if ($subscriber) {
            return response()->json(['error' => true, 'message' => 'البريد الالكتروني موجود بالفعل']);
        }

        $subscriber = new \App\Models\NewsletterSubscriber();
        $subscriber->email = $data['subscriber_email'];
        $subscriber->save();
        // send telegrame notification to admin
        $data = [
            'email' => $request->subscriber_email,
        ];
        // send telegram message to admin
        $job = SendTelegramInfoAboutNewNewsletterSubscriber::dispatch($data);

        return response()->json(['success' => true, 'message' => 'تم التسجيل بنجاح']);
    }
}
