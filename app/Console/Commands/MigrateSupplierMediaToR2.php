<?php

namespace App\Console\Commands;

use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierProductImages;
use App\Models\Supplier\SupplierProducts;
use App\Models\Supplier\SupplierProductVideos;
use App\Services\Supplier\SupplierMediaService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateSupplierMediaToR2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supplier:migrate-r2
                            {--store= : Migrate a specific supplier store by name or tenant_id}
                            {--limit= : Limit the number of products to process}
                            {--dry-run : Preview files to migrate without actually uploading to R2}
                            {--delete-local : Delete local file from server after verifying R2 upload}
                            {--type=all : File type to migrate: all, images, gallery, videos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely and gradually migrate supplier media (images, gallery, videos) to Cloudflare R2';

    public function handle(SupplierMediaService $mediaService): int
    {
        $storeOption = $this->option('store');
        $limitOption = $this->option('limit') ? (int) $this->option('limit') : null;
        $dryRun = (bool) $this->option('dry-run');
        $deleteLocal = (bool) $this->option('delete-local');
        $typeOption = strtolower((string) $this->option('type'));

        $this->info('===========================================================');
        $this->info('    Cloudflare R2 - Supplier Media Safe Migration Tool     ');
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

        // Fetch suppliers
        $suppliersQuery = Supplier::query();
        if (!empty($storeOption)) {
            $suppliersQuery->where(function ($q) use ($storeOption) {
                $q->where('store_name', $storeOption)
                  ->orWhere('tenant_id', $storeOption);
            });
        }
        $suppliers = $suppliersQuery->get();

        if ($suppliers->isEmpty()) {
            $this->error('No suppliers found matching criteria.');
            return 0;
        }

        $totalMigratedFiles = 0;
        $totalBytes = 0;
        $failedFiles = 0;
        $skippedFiles = 0;

        foreach ($suppliers as $supplier) {
            $this->line('');
            $this->info("--> Processing Supplier: <fg=cyan>{$supplier->store_name}</> (Tenant: {$supplier->tenant_id})");

            $productsQuery = SupplierProducts::where('supplier_id', $supplier->id);
            if ($limitOption) {
                $productsQuery->limit($limitOption);
            }
            $products = $productsQuery->get();

            if ($products->isEmpty()) {
                $this->line('    No products found for this supplier.');
                continue;
            }

            foreach ($products as $product) {
                $this->line("    * Product #{$product->id}: {$product->name}");

                // 1. Migrate Main Image
                if (in_array($typeOption, ['all', 'images']) && !empty($product->image)) {
                    $localInfo = $this->resolveLocalFile($product->image);
                    if ($localInfo) {
                        if ($dryRun) {
                            $size = Storage::disk($localInfo['disk'])->size($localInfo['path']);
                            $this->line("      [DRY-RUN] Main image: {$localInfo['path']} (" . $this->formatBytes($size) . ")");
                            $totalMigratedFiles++;
                            $totalBytes += $size;
                        } else {
                            $res = $mediaService->migrateLocalFileToR2($localInfo['path'], $deleteLocal, $localInfo['disk']);
                            if ($res['success']) {
                                $product->image = $res['r2_url'];
                                $product->disk = 'r2';
                                $product->save();
                                $totalMigratedFiles++;
                                $totalBytes += $res['bytes'];
                                $this->info("      [OK] Main image migrated: {$localInfo['path']}");
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
                    $galleryImages = SupplierProductImages::where('product_id', $product->id)->get();
                    foreach ($galleryImages as $gImage) {
                        $localInfo = $this->resolveLocalFile($gImage->image_path);
                        if ($localInfo) {
                            if ($dryRun) {
                                $size = Storage::disk($localInfo['disk'])->size($localInfo['path']);
                                $this->line("      [DRY-RUN] Gallery image #{$gImage->id}: {$localInfo['path']} (" . $this->formatBytes($size) . ")");
                                $totalMigratedFiles++;
                                $totalBytes += $size;
                            } else {
                                $res = $mediaService->migrateLocalFileToR2($localInfo['path'], $deleteLocal, $localInfo['disk']);
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

                // 3. Migrate Videos
                if (in_array($typeOption, ['all', 'videos'])) {
                    $videos = SupplierProductVideos::where('product_id', $product->id)
                        ->where('type', 'local')
                        ->get();
                    foreach ($videos as $video) {
                        $localInfo = $this->resolveLocalFile($video->file_path);
                        if ($localInfo) {
                            if ($dryRun) {
                                $size = Storage::disk($localInfo['disk'])->size($localInfo['path']);
                                $this->line("      [DRY-RUN] Video #{$video->id}: {$localInfo['path']} (" . $this->formatBytes($size) . ")");
                                $totalMigratedFiles++;
                                $totalBytes += $size;
                            } else {
                                $res = $mediaService->migrateLocalFileToR2($localInfo['path'], $deleteLocal, $localInfo['disk']);
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
     * Resolve a stored path or URL to a valid local disk and relative path.
     *
     * @param string|null $path
     * @return array|null ['disk' => string, 'path' => string]
     */
    protected function resolveLocalFile(?string $path): ?array
    {
        if (empty($path)) {
            return null;
        }

        // Already pointing to R2 CDN
        $r2PublicUrl = rtrim((string) config('filesystems.disks.r2.url', ''), '/');
        if (!empty($r2PublicUrl) && str_starts_with($path, $r2PublicUrl)) {
            return null;
        }

        $cleanPath = $path;
        if (str_contains($cleanPath, 'storage/tenantsupplier/app/public/')) {
            $parts = explode('storage/tenantsupplier/app/public/', $cleanPath);
            $cleanPath = ltrim($parts[1] ?? '', '/');
        } elseif (str_contains($cleanPath, 'tenantsupplier/app/public/supplier/')) {
            $parts = explode('tenantsupplier/app/public/supplier/', $cleanPath);
            $cleanPath = ltrim($parts[1] ?? '', '/');
        } elseif (str_contains($cleanPath, 'tenantsupplier/app/public/')) {
            $parts = explode('tenantsupplier/app/public/', $cleanPath);
            $cleanPath = ltrim($parts[1] ?? '', '/');
        } elseif (str_contains($cleanPath, 'tenantsupplier/')) {
            $parts = explode('tenantsupplier/', $cleanPath);
            $cleanPath = ltrim($parts[1] ?? '', '/');
        } elseif (str_starts_with($cleanPath, 'http://') || str_starts_with($cleanPath, 'https://')) {
            $parsed = parse_url($cleanPath, PHP_URL_PATH);
            if ($parsed && str_contains($parsed, 'tenantsupplier/')) {
                $parts = explode('tenantsupplier/', $parsed);
                $cleanPath = ltrim($parts[1] ?? '', '/');
            } else {
                return null;
            }
        }

        $cleanPath = ltrim($cleanPath, '/');

        // Check disks
        if (Storage::disk('supplier')->exists($cleanPath)) {
            return ['disk' => 'supplier', 'path' => $cleanPath];
        }

        if (Storage::disk('public')->exists($cleanPath)) {
            return ['disk' => 'public', 'path' => $cleanPath];
        }

        if (Storage::disk('public')->exists('supplier/' . $cleanPath)) {
            return ['disk' => 'public', 'path' => 'supplier/' . $cleanPath];
        }

        return null;
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
