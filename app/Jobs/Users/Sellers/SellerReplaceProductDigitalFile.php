<?php

namespace App\Jobs\Users\Sellers;

use App\Models\Seller\SellerProducts;
use App\Models\TempUploads;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SellerReplaceProductDigitalFile implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public $productId;
    public $uploadId;

    public function __construct($productId, $uploadId)
    {
        $this->productId = $productId;
        $this->uploadId = $uploadId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $product = SellerProducts::find($this->productId);
        $upload = TempUploads::find($this->uploadId);

        Log::info('Debug upload/product', [
            'upload' => $upload,
            'product' => $product,
        ]);

        if (!$product || !$upload) {
            return;
        }

        if ($product->file) {
            Storage::disk('seller')->delete($product->file);
        }

        $storeName = get_seller_store_name(get_seller_data_from_id($product->seller_id)->tenant_id);

        $filename = basename($upload->path);

        $newPath = "{$storeName}/products/{$product->id}/file/{$filename}";

        Storage::disk('seller')->move($upload->path, $newPath);

        $product->update([
            'file' => $newPath,
        ]);

        // $product->file = $newPath;
        // $product->save();

        $upload->delete();
    }
}
