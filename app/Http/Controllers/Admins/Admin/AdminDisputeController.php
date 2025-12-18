<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\DisputeMessage;
use App\Models\DisputesArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class AdminDisputeController extends Controller
{
    // index
    public function index()
    {
        $disputes = Dispute::orderBy('id', 'desc')->paginate(10);

        return view('admins.admin.disputes.index', compact('disputes'));
    }

    // show
    public function show($id)
    {
        $dispute = Dispute::find($id);

        return view('admins.admin.disputes.show', compact('dispute'));
    }

    // update
    public function updateStatus(Request $request, $id)
    {
        $dispute = Dispute::find($id);
        $dispute->status = $request->status;
        $dispute->save();

        return back()->with('success', 'تم تحديث حالة الشكوى بنجاح ✅');
    }

    public function reply(Request $request, $disputeId)
    {
        $request->validate([
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|max:5120',
        ]);

        $dispute = Dispute::findOrFail($disputeId);
        if ($dispute->admin_id == null) {
            $dispute->admin_id = Auth::guard('admin')->id();
            $dispute->save();
        }
        $attachments = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('disputes/payment-proofs/despute-'.$disputeId.'/attachments/admin', 'public');
                $attachments[] = 'app/public/'.$path;
            }
        }

        // return response()->json(['success' => true, 'attachments' => json_encode($attachments)]);

        $message = DisputeMessage::create([
            'dispute_id' => $dispute->id,
            'sender_type' => 'admin',
            'sender_id' => Auth::guard('admin')->id(),
            'message' => $request->message,
            'attachments' => !empty($attachments) ? json_encode($attachments) : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => $request->message,
            'attachments' => $message->attachments ?? [],
            'sender' => $message->sender_type,
        ]);
    }

    public function fetch($id)
    {
        $messages = DisputeMessage::where('dispute_id', $id)
                ->orderBy('created_at', 'asc')
                ->get();

        // حساب عدد الرسائل غير المقروءة من الزبون
        $unreadCount = DisputeMessage::where('dispute_id', $id)
            ->where('sender_type', 'customer')
            ->where('is_read_by_admin', false)
            ->count();

        return response()->json([
            'messages' => $messages,
            'unread_count' => $unreadCount,
            'attachments' => $message->attachments ?? [],
        ]);
    }

    // وضع كل الرسائل كمقروءة من قبل الأدمن عند فتح الشات
    public function markAsRead($id)
    {
        DisputeMessage::where('dispute_id', $id)
            ->where('sender_type', 'customer')
            ->where('is_read_by_admin', false)
            ->update(['is_read_by_admin' => true]);

        return response()->json(['status' => 'success']);
    }

    // destroy
    public function destroy($id)
    {
        $dispute = Dispute::with('messages')->findOrFail($id);

        // check if dispute archived exists
        if (DisputesArchive::where('dispute_id', $id)->exists()) {
            return back()->with('error', 'هذه الشكوى تم حفظها من قبل');
            $dispute_archive = DisputesArchive::where('dispute_id', $id)->first();
            $data[] = [
                'fileName' => $dispute_archive->file_name,
                'filePath' => $dispute_archive->file_path,
            ];
        } else {
            // 🧾 إنشاء نسخة PDF قبل الحذف
            $data = $this->generatePdfBackup($id);
            // 🗂️ حفظ سجل الأرشيف في قاعدة البيانات
            DisputesArchive::create([
                'dispute_id' => $dispute->id,
                'file_name' => $data[0]['fileName'],
                'file_path' => $data[0]['filePath'],
                'customer_name' => $dispute->customer_name,
                'customer_phone' => $dispute->customer_phone,
                'customer_email' => $dispute->customer_email,
                'seller_id' => $dispute->seller_id,
                'order_number' => $dispute->order_number,
                'subject' => $dispute->subject,
                'description' => $dispute->description,
                'archived_at' => now(),
            ]);
        }

        // 🧹 حذف المرفقات من storage
        foreach ($dispute->messages as $msg) {
            if (!empty($msg->attachments)) {
                $attachments = is_string($msg->attachments)
                    ? json_decode($msg->attachments, true)
                    : $msg->attachments;

                if (is_array($attachments)) {
                    foreach ($attachments as $file) {
                        // $path = str_replace('app/public/', '', );
                        // Storage::disk('public')->delete($path);
                        Storage::disk('public')->deleteDirectory('disputes/payment-proofs/despute-'.$id);
                    }
                }
            }
        }

        // 🧨 حذف النزاع والرسائل من قاعدة البيانات
        $dispute->messages()->delete();
        $dispute->delete();

        return redirect()->route('admin.payment_proof.disputes')
            ->with('success', '✅ تم حذف النزاع بعد حفظ نسخة PDF احتياطية.');
    }

    protected function generatePdfBackup($disputeId)
    {
        $dispute = Dispute::with('messages')->findOrFail($disputeId);

        // ⚙️ تأكد من أن المرفقات مصفوفة فعلًا
        foreach ($dispute->messages as $msg) {
            if (is_string($msg->attachments)) {
                $decoded = json_decode($msg->attachments, true);
                $msg->attachments = is_array($decoded) ? $decoded : [];
            }
        }
        // get user data
        $user = get_user_data($dispute->seller_id);

        // 🧾 إنشاء PDF من الـ View باستخدام mPDF
        $pdf = \PDF::loadView('admins.admin.disputes.pdf', [
            'dispute' => $dispute,
            'user' => $user,
            'messages' => $dispute->messages,
        ], [], [
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P', // Portrait
            'default_font_size' => 12,
            'default_font' => 'Cairo', // الخط العربي المحدد في config/pdf.php
            'direction' => 'rtl', // اتجاه الكتابة من اليمين إلى اليسار
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 15,
            'margin_bottom' => 15,
        ]);

        $pdf->getMpdf()->setFooter('{PAGENO} / {nbpg}');

        // استخدام الخط العربي
        $pdf->getMpdf()->setFont('Amiri');

        // 📂 حفظ الـ PDF داخل storage
        // $fileName = 'dispute_'.$dispute->id.'_'.Str::random(6).'.pdf';
        $fileName = 'dispute_'.$dispute->id.'.pdf';
        $filePath = 'public/disputes/payment-proofs/archives/'.date('Y').'/'.date('m').'/'.$fileName;

        Storage::put($filePath, $pdf->output());
        $data[] = [
            'fileName' => $fileName,
            'filePath' => $filePath,
        ];

        return $data;
    }

    public function exportPdf($disputeId)
    {
        // ✅ إرجاع رابط التحميل
        return response()->download(storage_path('app/'.$filePath));
    }
}
