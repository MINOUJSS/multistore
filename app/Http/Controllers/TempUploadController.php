<?php

namespace App\Http\Controllers;

use App\Models\TempUploads;
use App\Services\Seller\SellerMediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TempUploadController extends Controller
{
    public function store(Request $request)
    {
        // 1. Verify file presence and PHP upload status
        if (! $request->hasFile('digital_file')) {
            return response()->json([
                'error' => 'لم يتم استلام أي ملف. قد يكون حجم الملف أكبر من الحد الأقصى المسموح به في إعدادات السيرفر (upload_max_filesize / post_max_size).',
            ], 422);
        }

        $file = $request->file('digital_file');

        // 2. Verify file validity before attempting to read mime/hash
        if (! $file->isValid()) {
            return response()->json([
                'error' => 'الملف المرفوع غير صالح أو حدث خطأ أثناء نقله: ' . $file->getErrorMessage(),
            ], 422);
        }

        // 3. Laravel Validation
        $validator = Validator::make($request->all(), [
            'digital_file' => 'required|file|max:512000', // 500MB maximum
        ], [
            'digital_file.required' => 'حقل الملف الرقمي مطلوب.',
            'digital_file.file' => 'يجب أن يكون المرفق ملفاً صالحاً.',
            'digital_file.max' => 'حجم الملف يتجاوز الحد الأقصى المسموح به (500 ميغابايت).',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
            ], 422);
        }

        $mediaService = app(SellerMediaService::class);
        $storeName = get_seller_store_name(auth()->user()->tenant_id);

        $path = $file->store(
            "{$storeName}/temp",
            'seller'
        );

        Log::info('Temp Upload Stored Path:', ['path' => $path]);

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
        $upload = TempUploads::where('user_id', auth()->id())->findOrFail($request->id);

        $targetDisk = $upload->disk ?? 'seller';
        Storage::disk($targetDisk)->delete($upload->path);
        $upload->delete();

        return response()->json(['ok' => true]);
    }
}
