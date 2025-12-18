<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SiteDisputeController extends Controller
{
    // create
    public function create()
    {
        return view('site.dispute.index');
    }

    /**
     * تخزين نزاع جديد.
     */
    public function store(Request $request)
    {
        // ✅ التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'order_number' => 'required|string|max:255',
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:30',
            'seller_id' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status'  => 'error',
        //         'message' => 'البيانات غير صحيحة.',
        //         'errors'  => $validator->errors()
        //     ], 422);
        // }

        // get user id
        $user_id = get_user_data($request->seller_id)->id;
        $user_type = get_user_data($request->seller_id)->type;

        // ✅ إنشاء النزاع
        $token = Str::random(40);

        $dispute = Dispute::create([
            'order_number' => $request->order_number,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'seller_id' => $request->seller_id,
            'subject' => $request->subject,
            'description' => $request->description,
            'status' => 'open',
            'access_token' => $token,
        ]);

        // ✅ رفع الملفات إن وُجدت
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('disputes/payment-proofs/despute-'.$dispute->id.'/attachments/customer/'.$request->order_number, 'public');
                $attachments[] = 'app/public/'.$path;
            }
        }
        //            'attachments' => !empty($attachments) ? json_encode($attachments) : null,
        $dispute->update([
            'attachments' => !empty($attachments) ? json_encode($attachments) : null,
        ]);

        $message = `<p>✅ تم إرسال الشكوى بنجاح!</p>
<p>احتفظ بالرابط التالي لمتابعة حالتها:</p>
<a href="{{ url('/dispute/track/'.$dispute->access_token) }}" target="_blank">
    رابط المتابعة
</a>'`;

        return redirect()->route('site.dispute.track', $dispute->access_token)->with('success', '✅ تم إرسال النزاع بنجاح! سيتم مراجعته من قبل فريق المنصة.');

        // // ✅ الرد بعد النجاح
        // return response()->json([
        //     'status'  => 'success',
        //     'message' => '✅ تم إرسال النزاع بنجاح! سيتم مراجعته من قبل فريق المنصة.',
        //     'data'    => $dispute,
        // ], 201);
    }

    public function track($token)
    {
        $dispute = Dispute::where('access_token', $token)->firstOrFail();

        return view('site.dispute.track', compact('dispute'));
    }

    public function reply(Request $request, $token)
    {
        $dispute = Dispute::where('access_token', $token)->firstOrFail();

        $validated = $request->validate([
            'message' => 'nullable|string|max:2000',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        if (empty($validated['message']) && !$request->hasFile('attachments')) {
            return response()->json(['message' => 'يرجى كتابة رسالة أو رفع مرفق.'], 422);
        }

        $paths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $pth = $file->store('disputes/payment-proofs/despute-'.$dispute->id.'/attachments/customer', 'public');
                $paths[] = 'app/public/'.$pth;
            }
        }

        $message = $dispute->messages()->create([
            'sender_type' => 'customer',
            'message' => $validated['message'] ?? '',
            'attachments' => !empty($paths) ? json_encode($paths) : null,
        ]);

        $attachments = collect($paths)->map(fn ($p) => ['url' => asset('storage/'.$p)])->toArray();

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال الرد بنجاح.',
            'attachments' => $message->attachments ?? [],
            'sender' => $message->sender_type,
        ]);
        // try {
        //     $dispute = Dispute::where('access_token', $token)->firstOrFail();

        //     $request->validate([
        //         'message' => 'required|string|max:2000',
        //     ]);
        //     $dispute->messages()->create([
        //         'sender_type' => 'customer',
        //         'message' => $request->message,
        //     ]);

        //     return response()->json([
        //         'success' => true,
        //         'message' => 'تم تحديث حالة النزاع بنجاح ✅',
        //         'status' => $dispute->status,
        //     ]);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'حدث خطأ أثناء التحديث: '.$e->getMessage(),
        //     ], 500);
        // }

        // return back()->with('success', 'تم إرسال ردك بنجاح ✅');
    }

    public function fetchMessages($token)
    {
        $dispute = Dispute::where('access_token', $token)->firstOrFail();
        $after = request()->query('after', 0);

        $messages = $dispute->messages()
            ->where('id', '>', $after)
            ->orderBy('id')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'sender_type' => $msg->sender_type,
                    'message' => e($msg->message),
                    'time_ago' => $msg->created_at->diffForHumans(),
                    'attachments' => $msg->attachments ?? [],
                ];
            });

        return response()->json([
            'messages' => $messages,
        ]);

        // try {
        //     // 🔹 جلب النزاع عبر الـ token
        //     $dispute = Dispute::where('access_token', $token)->firstOrFail();

        //     // 🔹 تحديد آخر ID تم تحميله من الواجهة
        //     $afterId = $request->query('after', 0);

        //     // 🔹 جلب الرسائل الجديدة فقط
        //     $messages = $dispute->messages()
        //         ->where('id', '>', $afterId)
        //         ->orderBy('id', 'asc')
        //         ->get();

        //     // 🔹 تحويل المرفقات والوقت البشري لكل رسالة
        //     $formatted = $messages->map(function ($msg) {
        //         return [
        //             'id' => $msg->id,
        //             'sender_type' => $msg->sender_type,
        //             'message' => $msg->message,
        //             'time_ago' => $msg->created_at->diffForHumans(),
        //             'attachments' => $msg->attachments ? collect(json_decode($msg->attachments, true))
        //                 ->map(fn ($path) => asset('storage/'.str_replace('app/public/', '', $path)))
        //                 ->toArray() : [],
        //         ];
        //     });

        //     return response()->json([
        //         'success' => true,
        //         'messages' => $formatted,
        //     ]);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'حدث خطأ أثناء جلب الرسائل: '.$e->getMessage(),
        //     ], 500);
        // }
    }
}
