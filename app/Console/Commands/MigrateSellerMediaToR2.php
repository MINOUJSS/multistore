<?php

namespace App\Console\Commands;

use App\Models\Seller\Seller;
use App\Models\Seller\SellerProductImages;
use App\Models\Seller\SellerProducts;
use App\Models\Seller\SellerProductVideos;
use App\Services\Seller\SellerMediaService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateSellerMediaToR2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seller:migrate-r2
                            {--store= : Migrate a specific seller store by name or tenant_id}
                            {--limit= : Limit the number of products to process}
                            {--dry-run : Preview files to migrate without actually uploading to R2}
                            {--delete-local : Delete local file from server after verifying R2 upload}
                            {--type=all : File type to migrate: all, images, gallery, digital, videos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely and gradually migrate seller media (images, gallery, digital files, videos) to Cloudflare R2';

    public function handle(SellerMediaService $mediaService): int
    {
        $storeOption = $this->option('store');
        $limitOption = $this->option('limit') ? (int) $this->option('limit') : null;
        $dryRun = (bool) $this->option('dry-run');
        $deleteLocal = (bool) $this->option('delete-local');
        $typeOption = strtolower((string) $this->option('type'));

        $this->info('===========================================================');
        $this->info('      Cloudflare R2 - Seller Media Safe Migration Tool     ');
        $this->info('===========================================================');

        if ($dryRun) {
            $this->warn(' [DRY-RUN MODE] No files will be uploaded or deleted.');
        }

        if ($deleteLocal && !$dryRun) {
            $this->warn(' [NOTICE] --delete-local is active: Local files will be removed after verified R2 upload.');
        }

        // Verify R2 disk configuration
        if (!$dryRun) {
            $r2Bucket = config('filesystems.disks.r2.bucket');
            $r2Key = config('filesystems.disks.r2.key');
            if (empty($r2Bucket) || empty($r2Key)) {
                $this->error('Cloudflare R2 is not configured in .env (R2_BUCKET or R2_ACCESS_KEY_ID is missing).');
                $this->line('Please add your R2 credentials to .env before running migration.');
                return 1;
            }
        }

        // Fetch sellers
        $sellersQuery = Seller::query();
        if (!empty($storeOption)) {
            $sellersQuery->where(function ($q) use ($storeOption) {
                $q->where('store_name', $storeOption)
                  ->orWhere('tenant_id', $storeOption);
            });
        }
        $sellers = $sellersQuery->get();

        if ($sellers->isEmpty()) {
            $this->error('No sellers found matching criteria.');
            return 0;
        }

        $totalMigratedFiles = 0;
        $totalBytes = 0;
        $failedFiles = 0;
        $skippedFiles = 0;

        foreach ($sellers as $seller) {
            $this->line('');
            $this->info("--> Processing Seller: <fg=cyan>{$seller->store_name}</> (Tenant: {$seller->tenant_id})");

            $productsQuery = SellerProducts::where('seller_id', $seller->id);
            if ($limitOption) {
                $productsQuery->limit($limitOption);
            }
            $products = $productsQuery->get();

            if ($products->isEmpty()) {
                $this->line('    No products found for this seller.');
                continue;
            }

            foreach ($products as $product) {
                $this->line("    * Product #{$product->id}: {$product->name}");

                // 1. Migrate Main Image
                if (in_array($typeOption, ['all', 'images']) && !empty($product->image)) {
                    $localPath = $this->extractLocalRelativePath($product->image);
                    if ($localPath && Storage::disk('seller')->exists($localPath)) {
                        if ($dryRun) {
                            $size = Storage::disk('seller')->size($localPath);
                            $this->line("      [DRY-RUN] Main image: {$localPath} (" . $this->formatBytes($size) . ")");
                            $totalMigratedFiles++;
                            $totalBytes += $size;
                        } else {
                            $res = $mediaService->migrateLocalFileToR2($localPath, $deleteLocal);
                            if ($res['success']) {
                                $product->image = $res['r2_url'];
                                $product->disk = 'r2';
                                $product->save();
                                $totalMigratedFiles++;
                                $totalBytes += $res['bytes'];
                                $this->info("      [OK] Main image migrated: {$localPath}");
                            } else {
                                $failedFiles++;
                                $this->error("      [FAIL] Main image: {$res['message']}");
                            }
                        }
                    } else {
                        $skippedFiles++;
                    }
                }

                // 2. Migrate Gallery Images
                if (in_array($typeOption, ['all', 'gallery'])) {
                    $galleryImages = SellerProductImages::where('product_id', $product->id)->get();
                    foreach ($galleryImages as $gImage) {
                        $localPath = $this->extractLocalRelativePath($gImage->image_path);
                        if ($localPath && Storage::disk('seller')->exists($localPath)) {
                            if ($dryRun) {
                                $size = Storage::disk('seller')->size($localPath);
                                $this->line("      [DRY-RUN] Gallery image #{$gImage->id}: {$localPath} (" . $this->formatBytes($size) . ")");
                                $totalMigratedFiles++;
                                $totalBytes += $size;
                            } else {
                                $res = $mediaService->migrateLocalFileToR2($localPath, $deleteLocal);
                                if ($res['success']) {
                                    $gImage->image_path = $res['r2_url'];
                                    $gImage->disk = 'r2';
                                    $gImage->save();
                                    $totalMigratedFiles++;
                                    $totalBytes += $res['bytes'];
                                    $this->info("      [OK] Gallery image #{$gImage->id} migrated");
                                } else {
                                    $failedFiles++;
                                    $this->error("      [FAIL] Gallery image #{$gImage->id}: {$res['message']}");
                                }
                            }
                        } else {
                            $skippedFiles++;
                        }
                    }
                }

                // 3. Migrate Digital Product File
                if (in_array($typeOption, ['all', 'digital']) && !empty($product->file)) {
                    $localPath = $this->extractLocalRelativePath($product->file);
                    if ($localPath && Storage::disk('seller')->exists($localPath)) {
                        if ($dryRun) {
                            $size = Storage::disk('seller')->size($localPath);
                            $this->line("      [DRY-RUN] Digital file: {$localPath} (" . $this->formatBytes($size) . ")");
                            $totalMigratedFiles++;
                            $totalBytes += $size;
                        } else {
                            $res = $mediaService->migrateLocalFileToR2($localPath, $deleteLocal);
                            if ($res['success']) {
                                $product->file_disk = 'r2';
                                if (!empty($res['r2_path'])) {
                                    $product->file = $res['r2_path'];
                                }
                                $product->save();
                                $totalMigratedFiles++;
                                $totalBytes += $res['bytes'];
                                $this->info("      [OK] Digital file migrated: {$localPath}");
                            } else {
                                $failedFiles++;
                                $this->error("      [FAIL] Digital file: {$res['message']}");
                            }
                        }
                    } else {
                        $skippedFiles++;
                    }
                }

                // 4. Migrate Videos
                if (in_array($typeOption, ['all', 'videos'])) {
                    $videos = SellerProductVideos::where('product_id', $product->id)
                        ->where('type', 'local')
                        ->get();
                    foreach ($videos as $video) {
                        $localPath = $this->extractLocalRelativePath($video->file_path);
                        if ($localPath && Storage::disk('seller')->exists($localPath)) {
                            if ($dryRun) {
                                $size = Storage::disk('seller')->size($localPath);
                                $this->line("      [DRY-RUN] Video #{$video->id}: {$localPath} (" . $this->formatBytes($size) . ")");
                                $totalMigratedFiles++;
                                $totalBytes += $size;
                            } else {
                                $res = $mediaService->migrateLocalFileToR2($localPath, $deleteLocal);
                                if ($res['success']) {
                                    $video->file_disk = 'r2';
                                    if (!empty($res['r2_url'])) {
                                        $video->file_path = $res['r2_url'];
                                    }
                                    $video->save();
                                    $totalMigratedFiles++;
                                    $totalBytes += $res['bytes'];
                                    $this->info("      [OK] Video #{$video->id} migrated");
                                } else {
                                    $failedFiles++;
                                    $this->error("      [FAIL] Video #{$video->id}: {$res['message']}");
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->line('');
        $this->info('===========================================================');
        $this->info('                   Migration Summary                       ');
        $this->info('===========================================================');
        $this->line(" Total Files Processed/Migrated : {$totalMigratedFiles}");
        $this->line(" Total Size Transferred        : " . $this->formatBytes($totalBytes));
        $this->line(" Skipped (Already R2 or Missing): {$skippedFiles}");
        if ($failedFiles > 0) {
            $this->error(" Failed Files                   : {$failedFiles}");
        } else {
            $this->info(" Failed Files                   : 0 (All Success)");
        }
        $this->info('===========================================================');

        return 0;
    }

    /**
     * Extract relative path under seller storage from raw database values.
     *
     * @param string|null $path
     * @return string|null
     */
    protected function extractLocalRelativePath(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        // Already pointing to R2 CDN
        $r2PublicUrl = rtrim((string) config('filesystems.disks.r2.url', ''), '/');
        if (!empty($r2PublicUrl) && str_starts_with($path, $r2PublicUrl)) {
            return null;
        }

        if (str_contains($path, '/storage/app/public/seller/')) {
            $parts = explode('/storage/app/public/seller/', $path);
            return ltrim($parts[1] ?? '', '/');
        }

        if (str_contains($path, 'storage/app/public/seller/')) {
            $parts = explode('storage/app/public/seller/', $path);
            return ltrim($parts[1] ?? '', '/');
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            // Not a local seller path
            return null;
        }

        return ltrim($path, '/');
    }

    /**
     * Format bytes into human readable format.
     *
     * @param int $bytes
     * @return string
     */
    protected function formatBytes(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        }
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}
