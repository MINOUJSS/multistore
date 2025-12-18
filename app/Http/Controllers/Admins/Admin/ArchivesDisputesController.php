<?php

namespace App\Http\Controllers\Admins\Admin;

use Illuminate\Http\Request;
use App\Models\DisputesArchive;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ArchivesDisputesController extends Controller
{
    //index
    public function index()
    {
        $archives = DisputesArchive::latest()->paginate(10);
        return view('admins.admin.disputes.archives.index', compact('archives'));
    }
    //download file
    public function download($id)
    {
        $archive = DisputesArchive::findOrFail($id);
        return Storage::disk('public')->download(str_replace('public/','',$archive->file_path));
    }
    //destroy
    public function destroy($id)
    {
        $archive = DisputesArchive::findOrFail($id);
        // dd($archive);
        // حذف الملف المرفق
        //str_replace('public/','',
        Storage::disk('public')->delete(str_replace('public/','',$archive->file_path));
        $archive->delete();
        return redirect()->route('admin.payment_proof.disputes.archives')->with('success', 'تم حذف الشكوى بنجاح');
    }
}
