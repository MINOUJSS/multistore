<?php

namespace App\Services\Admins\Admin;

use App\Models\Seller\Seller;
use App\Models\TempUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SellerTempCleanupService
{
    /**
     * Hours threshold to consider a seller offline (default: 1 hour).
     */
    protected int $offlineHoursThreshold = 1;

    public function __construct(int $offlineHoursThreshold = 1)
    {
        $this->offlineHoursThreshold = $offlineHoursThreshold;
    }

    /**
     * Get offline temp files statistics (files count, bytes, formatted size) without deleting.
     *
     * @param int|null $hours
     * @return array
     */
    public function getOfflineTempStats(?int $hours = null): array
    {
        $thresholdHours = $hours ?? $this->offlineHoursThreshold;
        $sellers = Seller::with(['user.last_seen'])->get();

        $totalFiles = 0;
        $totalBytes = 0;
        $offlineSellersTotal = 0;
        $offlineSellersWithTemp = 0;

        foreach ($sellers as $seller) {
            if ($this->isSellerOffline($seller, $thresholdHours)) {
                $offlineSellersTotal++;
                $storeName = get_seller_store_name($seller->tenant_id);
                $candidateDirs = array_unique([
                    $storeName . '/temp',
                    $seller->tenant_id . '/temp',
                ]);

                $sellerHasTemp = false;
                foreach ($candidateDirs as $tempDir) {
                    if (Storage::disk('seller')->exists($tempDir)) {
                        $files = Storage::disk('seller')->allFiles($tempDir);
                        $fileCount = count($files);
                        if ($fileCount > 0) {
                            $totalFiles += $fileCount;
                            $sellerHasTemp = true;
                            foreach ($files as $file) {
                                try {
                                    $totalBytes += Storage::disk('seller')->size($file);
                                } catch (\Throwable $e) {
                                    // ignore unreadable file size
                                }
                            }
                        }
                    }
                }

                if ($sellerHasTemp) {
                    $offlineSellersWithTemp++;
                }
            }
        }

        return [
            'total_files' => $totalFiles,
            'total_bytes' => $totalBytes,
            'formatted_size' => $this->formatBytes($totalBytes),
            'offline_sellers_total' => $offlineSellersTotal,
            'offline_sellers_with_temp_count' => $offlineSellersWithTemp,
            'threshold_hours' => $thresholdHours,
        ];
    }

    /**
     * Clean temp files for all sellers who are offline (> threshold hours).
     *
     * @param int|null $hours
     * @return array
     */
    public function cleanAllOfflineSellers(?int $hours = null): array
    {
        $thresholdHours = $hours ?? $this->offlineHoursThreshold;
        $sellers = Seller::with(['user.last_seen'])->get();

        $totalCleanedSellers = 0;
        $totalDeletedFiles = 0;
        $totalFreedBytes = 0;
        $cleanedStores = [];

        foreach ($sellers as $seller) {
            if ($this->isSellerOffline($seller, $thresholdHours)) {
                $result = $this->cleanTempDirectory($seller);
                if ($result['deleted_files'] > 0) {
                    $totalCleanedSellers++;
                    $totalDeletedFiles += $result['deleted_files'];
                    $totalFreedBytes += $result['freed_bytes'];
                    $cleanedStores[] = [
                        'store_name' => $seller->store_name,
                        'tenant_id' => $seller->tenant_id,
                        'deleted_files' => $result['deleted_files'],
                        'freed_bytes' => $result['freed_bytes'],
                    ];
                }
            }
        }

        return [
            'success' => true,
            'threshold_hours' => $thresholdHours,
            'cleaned_sellers_count' => $totalCleanedSellers,
            'deleted_files' => $totalDeletedFiles,
            'freed_bytes' => $totalFreedBytes,
            'freed_formatted' => $this->formatBytes($totalFreedBytes),
            'cleaned_stores' => $cleanedStores,
        ];
    }

    /**
     * Clean temp files for a single seller if offline.
     *
     * @param Seller $seller
     * @param int|null $hours
     * @return array
     */
    public function cleanForSeller(Seller $seller, ?int $hours = null): array
    {
        $thresholdHours = $hours ?? $this->offlineHoursThreshold;

        if (!$this->isSellerOffline($seller, $thresholdHours)) {
            return [
                'success' => false,
                'is_offline' => false,
                'message' => 'البائع متصل حالياً أو كان نشطاً خلال الساعة الأخيرة.',
                'deleted_files' => 0,
                'freed_bytes' => 0,
                'freed_formatted' => '0 B',
            ];
        }

        $result = $this->cleanTempDirectory($seller);

        return [
            'success' => true,
            'is_offline' => true,
            'store_name' => $seller->store_name,
            'deleted_files' => $result['deleted_files'],
            'freed_bytes' => $result['freed_bytes'],
            'freed_formatted' => $this->formatBytes($result['freed_bytes']),
        ];
    }

    /**
     * Check if a seller is offline based on last_seen table (> threshold hours).
     *
     * @param Seller $seller
     * @param int $thresholdHours
     * @return bool
     */
    public function isSellerOffline(Seller $seller, int $thresholdHours = 1): bool
    {
        $user = $seller->user ?? get_user_data($seller->tenant_id);
        if (!$user) {
            return true;
        }

        $lastSeen = $user->last_seen()->first();
        if (!$lastSeen || empty($lastSeen->last_seen_at)) {
            return true;
        }

        $threshold = now()->subHours($thresholdHours);
        return $lastSeen->last_seen_at < $threshold;
    }

    /**
     * Safely delete all contents inside the seller's temp folder and sync database.
     *
     * @param Seller $seller
     * @return array
     */
    protected function cleanTempDirectory(Seller $seller): array
    {
        $deletedCount = 0;
        $freedBytes = 0;

        // Determine store directory inside 'seller' disk (storage/app/public/seller/)
        $storeName = get_seller_store_name($seller->tenant_id);
        $candidateDirs = array_unique([
            $storeName . '/temp',
            $seller->tenant_id . '/temp',
        ]);

        foreach ($candidateDirs as $tempDir) {
            if (Storage::disk('seller')->exists($tempDir)) {
                $files = Storage::disk('seller')->allFiles($tempDir);
                foreach ($files as $file) {
                    try {
                        $size = Storage::disk('seller')->size($file);
                        if (Storage::disk('seller')->delete($file)) {
                            $deletedCount++;
                            $freedBytes += $size;
                        }
                    } catch (\Throwable $e) {
                        Log::warning("Failed to delete temp file: {$file}. Error: " . $e->getMessage());
                    }
                }

                // Delete any subdirectories inside temp
                $subDirs = Storage::disk('seller')->allDirectories($tempDir);
                foreach ($subDirs as $subDir) {
                    try {
                        Storage::disk('seller')->deleteDirectory($subDir);
                    } catch (\Throwable $e) {
                        Log::warning("Failed to delete sub-temp directory: {$subDir}. Error: " . $e->getMessage());
                    }
                }
            }
        }

        // Clean up corresponding TempUploads records in the database
        $user = $seller->user ?? get_user_data($seller->tenant_id);
        if ($user) {
            try {
                TempUploads::where('user_id', $user->id)
                    ->where(function ($q) use ($storeName, $seller) {
                        $q->where('path', 'like', "%{$storeName}/temp/%")
                          ->orWhere('path', 'like', "%{$seller->tenant_id}/temp/%")
                          ->orWhere('path', 'like', "%/temp/%");
                    })
                    ->delete();
            } catch (\Throwable $e) {
                Log::warning("Failed to delete temp_uploads records for user {$user->id}: " . $e->getMessage());
            }
        }

        return [
            'deleted_files' => $deletedCount,
            'freed_bytes' => $freedBytes,
        ];
    }

    /**
     * Format bytes to human readable format (KB, MB, GB).
     *
     * @param int $bytes
     * @return string
     */
    public function formatBytes(int $bytes): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = (int) floor(log($bytes, 1024));
        $i = min($i, count($units) - 1);

        return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
    }
}
