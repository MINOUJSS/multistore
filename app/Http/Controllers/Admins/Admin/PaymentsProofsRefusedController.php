<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\UsersPaymentsProofsRefused;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class PaymentsProofsRefusedController extends Controller
{
    // index
    public function index()
    {
        if (auth()->guard('admin')->user()->type != 'admin') {
            $proofs = UsersPaymentsProofsRefused::where('admin_id', auth()->guard('admin')->user()->id)->orWhere('admin_id', null)->with(['user', 'admin'])
        ->orderByDesc('created_at')
        ->paginate(10);
        } else {
            $proofs = UsersPaymentsProofsRefused::with(['user', 'admin'])
        ->orderByDesc('created_at')
        ->paginate(10);
        }

        return view('admins.admin.payments_proofs_refused.index', compact('proofs'));
    }

    // show
    public function show($id)
    {
        $proof = UsersPaymentsProofsRefused::with(['user', 'admin'])->findOrFail($id);
        // update the admin_id
        if (!auth()->guard('admin')->user()->type == 'admin') {
            $proof->update(['admin_id' => auth()->guard('admin')->user()->id]);
        }

        return view('admins.admin.payments_proofs_refused.show', compact('proof'));
    }

    // update
    public function update(Request $request, $id)
    {
        $proof = UsersPaymentsProofsRefused::findOrFail($id);
        $proof->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back();
    }

    // destroy
    public function destroy($id)
    {
        // get the proof
        $proof = UsersPaymentsProofsRefused::findOrFail($id);

        // dd(get_supplier_store_name(get_supplier_data_from_id($proof->user_id)->tenant_id).'/customer_payment_proofs/'.$proof->created_at->format('Y').'/'.$proof->created_at->format('m').'/'.$proof->created_at->format('d'));

        // create pdf file
        $data = $this->generatePdfBackup($id);

        // create archive
        $archive = new \App\Models\PaymentsProofsRefusedsArchive();
        $archive->create([
            'original_proof_id' => $proof->id,
            'order_number' => $proof->order_number,
            'user_id' => $proof->user_id,
            'user_name' => get_user_data_from_id($proof->user_id)->name,
            'user_email' => get_user_data_from_id($proof->user_id)->email,
            'user_phone' => get_user_data_from_id($proof->user_id)->phone,
            'proof_path' => $proof->proof_path,
            'refuse_reason' => $proof->refuse_reason,
            'admin_notes' => $proof->admin_notes,
            'admin_id' => $proof->admin_id,
            'admin_name' => get_admin_data_from_id($proof->admin_id) != null ? get_admin_data_from_id($proof->admin_id)->name : null,
            'admin_email' => get_admin_data_from_id($proof->admin_id) != null ? get_admin_data_from_id($proof->admin_id)->email : null,
            // 'admin_phone' => get_admin_data_from_id($proof->admin_id)!=null? get_admin_data_from_id($proof->admin_id)->phone : null,
            'status' => 'archived',
            'archive_pdf_path' => 'general/'.$data[0]['filePath'],
            'refused_at' => $proof->created_at,
            'archived_at' => now(),
        ]);
        // clean storage
        $chat_folder_path = 'proofs_refused_chats';
        $chat_files = Storage::disk('general')->files($chat_folder_path.'/'.$proof->id);

        if (Storage::disk('general')->exists($chat_folder_path.'/'.$proof->id)) {
            Storage::disk('general')->deleteDirectory($chat_folder_path.'/'.$proof->id);
        }
        //if chat floder is empty
        if (empty($chat_files)) {
            // Folder is empty
            Storage::disk('general')->deleteDirectory($chat_folder_path);
        }
        // delete the proof
        $proof->delete();

        return redirect()->back();
    }

    // pdf functions
    protected function generatePdfBackup($proofRefusedId)
    {
        $proof = UsersPaymentsProofsRefused::with('messages')->findOrFail($proofRefusedId);

        // ⚙️ تأكد من أن المرفقات مصفوفة فعلًا
        foreach ($proof->messages as $msg) {
            if (is_string($msg->attachments)) {
                $decoded = json_decode($msg->attachments, true);
                $msg->attachments = is_array($decoded) ? $decoded : [];
            }
        }
        // get user data
        $user = get_user_data($proof->sender_id);

        // 🧾 إنشاء PDF من الـ View باستخدام mPDF
        $pdf = \PDF::loadView('admins.admin.payments_proofs_refused.pdf', [
            'proof' => $proof,
            'user' => $user,
            'messages' => $proof->messages,
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
        // $fileName = 'dispute_'.$proof->id.'_'.Str::random(6).'.pdf';
        $fileName = 'proof_refused_'.$proof->order_number.'.pdf';
        $filePath = 'archives/proofs-refused/'.date('Y').'/'.date('m').'/'.$fileName;

        Storage::disk('general')->put($filePath, $pdf->output());
        $data[] = [
            'fileName' => $fileName,
            'filePath' => $filePath,
        ];

        return $data;
    }

    public function exportPdf($proofRefusedId)
    {
        // ✅ إرجاع رابط التحميل
        return response()->download(storage_path('app/'.$filePath));
    }
}
