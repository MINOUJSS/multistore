<?php

namespace App\Jobs\Users\Sellers;

use App\Models\Seller\SellerProducts;
use App\Models\TempUploads;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SellerAttachProductMedia implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public SellerProducts $product;
    public array $uploadIds;

    public function __construct(SellerProducts $product, array $uploadIds)
    {
        $this->product = $product;
        $this->uploadIds = $uploadIds;
    }

    public function handle(): void
    {
        foreach ($this->uploadIds as $uploadId) {
            $upload = TempUploads::find($uploadId);

            if (!$upload) {
                continue;
            }

            $seller_data = get_seller_data_from_id($this->product->seller_id);

            $storeName = get_seller_store_name(
                $seller_data->tenant_id
            );

            $directory = "{$storeName}/products/{$this->product->id}/file";

            $filename = basename($upload->path);

            $newPath = "{$directory}/{$filename}";

            // copy temp -> final

            \Log::info('upload path', ['path' => $upload->path]);

            \Log::info('exists?', [
                'exists' => Storage::disk('seller')->exists($upload->path),
            ]);

            Storage::disk('seller')->move(
                $upload->path,
                $newPath
            );

            // delete temp file
            // Storage::disk('seller')->delete($upload->path);

            $this->product->file = $newPath;
            $this->product->save();

            // $this->product->update([
            //     'file' => $newPath,
            // ]);

            // delete temp db record
            $upload->delete();
        }
    }
}
