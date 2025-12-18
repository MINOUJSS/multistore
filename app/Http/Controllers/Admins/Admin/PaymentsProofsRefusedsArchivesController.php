<?php

namespace App\Http\Controllers\Admins\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\PaymentsProofsRefusedsArchive;

class PaymentsProofsRefusedsArchivesController extends Controller
{
    // index
    public function index()
    {
        $archives = PaymentsProofsRefusedsArchive::latest()->paginate(10);

        return view('admins.admin.payments_proofs_refused.archives.index', compact('archives'));
    }

    public function download($id)
    {
        $archive = PaymentsProofsRefusedsArchive::findOrFail($id);

        return Storage::disk('general')->download('archives/proofs-refused/'.$archive->created_at->format('Y').'/'.$archive->created_at->format('m').'/proof_refused_'.$archive->order_number.'.pdf');
    }

    // destroy
    public function destroy($id)
    {
        $archive = PaymentsProofsRefusedsArchive::findOrFail($id);
        // حذف الملف المرفق
        // str_replace('public/','',
        if (Storage::disk('general')->exists('archives/proofs-refused/'.$archive->created_at->format('Y').'/'.$archive->created_at->format('m').'/proof_refused_'.$archive->order_number.'.pdf')) {
            Storage::disk('general')->delete('archives/proofs-refused/'.$archive->created_at->format('Y').'/'.$archive->created_at->format('m').'/proof_refused_'.$archive->order_number.'.pdf');
        }
        // delete month folder if it is empty
        if (empty(Storage::disk('general')->files('archives/proofs-refused/'.$archive->created_at->format('Y').'/'.$archive->created_at->format('m')))) {
            Storage::disk('general')->deleteDirectory('archives/proofs-refused/'.$archive->created_at->format('Y').'/'.$archive->created_at->format('m'));
        }
        // delete year folder if it is empty
        if (empty(Storage::disk('general')->files('archives/proofs-refused/'.$archive->created_at->format('Y')))) {
            Storage::disk('general')->deleteDirectory('archives/proofs-refused/'.$archive->created_at->format('Y'));
        }
        // delete proof-refused folder if it is empty
        if (empty(Storage::disk('general')->files('archives/proofs-refused'))) {
            Storage::disk('general')->deleteDirectory('archives/proofs-refused');
        }
        // delete archive folder if it is empty
        if (empty(Storage::disk('general')->files('archives'))) {
            Storage::disk('general')->deleteDirectory('archives');
        }
        // delte general folder if it is empty
        if (empty(Storage::disk('general')->files(''))) {
            Storage::disk('general')->deleteDirectory('');
        }
        // clear supplier storage
        $proof_folder_path = get_supplier_store_name(get_supplier_data_from_id($archive->user_id)->tenant_id).'/customer_payment_proofs/'.$this->data_format($archive->archived_at)->format('Y').'/'.$this->data_format($archive->archived_at)->format('m');
        $files = Storage::disk('supplier')->files($proof_folder_path.'/'.$this->data_format($archive->archived_at)->format('d'));
        
        // dd($proof_folder_path,Storage::disk('supplier'));
        if (Storage::disk('supplier')->exists($proof_folder_path.'/'.$this->data_format($archive->archived_at)->format('d').'/'.basename($archive->proof_path))) {
            Storage::disk('supplier')->delete($proof_folder_path.'/'.$this->data_format($archive->archived_at)->format('d').'/'.basename($archive->proof_path));
        }
        // delete day folder if it is empty
        if (empty($files)) {
            // Folder is empty
            Storage::disk('supplier')->deleteDirectory($proof_folder_path.'/'.$this->data_format($archive->archived_at)->format('d'));
        }
        //delete month folder if it is empty
        if (empty(Storage::disk('supplier')->files($proof_folder_path.'/'.$this->data_format($archive->archived_at)->format('m')))) {
            Storage::disk('supplier')->deleteDirectory($proof_folder_path.'/'.$this->data_format($archive->archived_at)->format('m'));
        }
        // delete year folder if it is empty
        if (empty(Storage::disk('supplier')->files($proof_folder_path))) {
            Storage::disk('supplier')->deleteDirectory($proof_folder_path);
        }
        //delete customer_payment_proofs folder if it is empty
        if (empty(Storage::disk('supplier')->files(get_supplier_store_name(get_supplier_data_from_id($archive->user_id)->tenant_id).'/customer_payment_proofs'))) {
            Storage::disk('supplier')->deleteDirectory(get_supplier_store_name(get_supplier_data_from_id($archive->user_id)->tenant_id).'/customer_payment_proofs');
        }
        //delet saoura folder if it is empty
        if (empty(Storage::disk('supplier')->files(get_supplier_store_name(get_supplier_data_from_id($archive->user_id)->tenant_id)))) {
            Storage::disk('supplier')->deleteDirectory(get_supplier_store_name(get_supplier_data_from_id($archive->user_id)->tenant_id));
        }
        // delete supplier folder if it is empty
        if (empty(Storage::disk('supplier')->files(''))) {
            Storage::disk('supplier')->deleteDirectory('');
        }
        //delete archive
        $archive->delete();

        return redirect()->back()->with('success', 'تم حذف الشكوى بنجاح');
    }
    protected function data_format($date)
    {
        return Carbon::parse($date);
    }
}
