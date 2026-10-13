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
        $download = admin_media_service()->download($archive->file_path);
        if ($download) {
            return $download;
        }

        return redirect()->back()->with('error', 'الملف غير موجود في الأرشيف.');
    }

    //destroy
    public function destroy($id)
    {
        $archive = DisputesArchive::findOrFail($id);
        admin_media_service()->deleteFile($archive->file_path);
        $archive->delete();
        return redirect()->route('admin.payment_proof.disputes.archives')->with('success', 'تم حذف الشكوى بنجاح');
    }

}
