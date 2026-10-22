<?php

namespace App\Http\Controllers;

use App\Models\TempUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TempUploadController extends Controller
{
    public function store(Request $request)
    {
        $mediaService = app(\App\Services\Seller\SellerMediaService::class);
        // dd(
        //     $request->all(),
        //     $_FILES,
        //     $request->file()
        // );
        $file = $request->file('digital_file');

        // \Log::info($mediaService->getActiveDisk());
        if ($mediaService) {
            $path = $file->store(
                get_seller_store_name(auth()->user()->tenant_id).'/temp',
                'seller'
            );
        } else {
            $path = $file->store(
                get_seller_store_name(auth()->user()->tenant_id).'/temp',
                'r2'
            );
        }

        \Log::info('Stored Path:', ['path' => $path]);

        $upload = TempUploads::create([
            'user_id' => auth()->id(),
            'disk' => $mediaService->getActiveDisk(),
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'type' => 'digital',
        ]);

        return response()->json([
            'id' => $upload->id,
        ]);
    }

    public function delete(Request $request)
    {
        $upload = TempUploads::findOrFail($request->id);

        Storage::disk('seller')->delete($upload->path);
        $upload->delete();

        return response()->json(['ok' => true]);
    }
}
