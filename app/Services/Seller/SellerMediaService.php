<?php

namespace App\Services\Seller;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SellerMediaService
{
    public const R2_PREFIX = 'seller';

    /**
     * Ensure a path or directory is prefixed with 'seller/' for Cloudflare R2 storage.
     *
     * @param string $path
     * @return string
     */
    public function prefixR2Path(string $path): string
    {
        $clean = ltrim(trim($path), '/');
        if (str_starts_with($clean, self::R2_PREFIX . '/')) {
            return $clean;
        }
        return self::R2_PREFIX . '/' . $clean;
    }

    /**
     * Get the active disk for new uploads ('r2' or 'seller').
     *
     * @return string
     */
    public function getActiveDisk(): string
    {
        return config('filesystems.seller_default_disk', 'seller');
    }

    /**
     * Store an uploaded file on the active seller disk.
     *
     * @param UploadedFile $file
     * @param string $directory Path relative to disk (e.g., "ayasworld/products/1/images")
     * @param string|null $disk Optional explicit disk override
     * @return array ['disk' => string, 'path' => string, 'url' => string]
     */
    public function storeFile(UploadedFile $file, string $directory, ?string $disk = null): array
    {
        $targetDisk = $disk ?? $this->getActiveDisk();
        $targetDir = $targetDisk === 'r2' ? $this->prefixR2Path($directory) : $directory;
        $storedPath = $file->store($targetDir, $targetDisk);

        return [
            'disk' => $targetDisk,
            'path' => $storedPath,
            'url'  => $this->getUrl($storedPath, $targetDisk),
        ];
    }

    /**
     * Move an already uploaded file (e.g., from temp upload) to its permanent location.
     *
     * @param string $sourcePath Path relative to disk
     * @param string $destinationPath Path relative to disk
     * @param string|null $disk
     * @return array ['disk' => string, 'path' => string, 'url' => string]
     */
    public function moveFile(string $sourcePath, string $destinationPath, ?string $disk = null): array
    {
        $targetDisk = $disk ?? $this->getActiveDisk();
        $dest = $targetDisk === 'r2' ? $this->prefixR2Path($destinationPath) : $destinationPath;

        if (Storage::disk($targetDisk)->exists($sourcePath)) {
            Storage::disk($targetDisk)->move($sourcePath, $dest);
        }

        return [
            'disk' => $targetDisk,
            'path' => $dest,
            'url'  => $this->getUrl($dest, $targetDisk),
        ];
    }

    /**
     * Extract clean relative path from any full URL or stored path.
     *
     * @param string $urlOrPath
     * @return string
     */
    public function extractRelativePath(string $urlOrPath): string
    {
        $path = trim($urlOrPath);

        if (filter_var($path, FILTER_VALIDATE_URL) || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            $parsed = parse_url($path, PHP_URL_PATH);
            if ($parsed) {
                $path = $parsed;
            }
        }

        $path = ltrim($path, '/');

        $prefixes = [
            'storage/app/public/seller/',
            'storage/app/public/',
            'app/public/seller/',
            'app/public/',
            'storage/',
        ];

        foreach ($prefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                $path = substr($path, strlen($prefix));
                break;
            }
        }

        return ltrim($path, '/');
    }

    /**
     * Safely delete a file from its disk (or both R2 and local disks if unknown).
     *
     * @param string|null $pathOrUrl
     * @param string|null $disk
     * @return bool
     */
    public function deleteFile(?string $pathOrUrl, ?string $disk = null): bool
    {
        if (empty($pathOrUrl)) {
            return false;
        }

        $relPath = $this->extractRelativePath($pathOrUrl);
        if (empty($relPath)) {
            return false;
        }

        $deleted = false;

        if ($disk) {
            $checkPath = $disk === 'r2' ? $this->prefixR2Path($relPath) : $relPath;
            if (Storage::disk($disk)->exists($checkPath)) {
                return Storage::disk($disk)->delete($checkPath);
            }
            if ($disk === 'r2' && Storage::disk('r2')->exists($relPath)) {
                return Storage::disk('r2')->delete($relPath);
            }
            return false;
        }

        // Check and delete from R2 if exists (both prefixed and raw)
        try {
            $r2Prefixed = $this->prefixR2Path($relPath);
            if (Storage::disk('r2')->exists($r2Prefixed)) {
                Storage::disk('r2')->delete($r2Prefixed);
                $deleted = true;
            } elseif (Storage::disk('r2')->exists($relPath)) {
                Storage::disk('r2')->delete($relPath);
                $deleted = true;
            }
        } catch (\Throwable $e) {
            Log::warning("SellerMediaService: failed checking/deleting file from R2: {$relPath}. Error: " . $e->getMessage());
        }

        // Check and delete from local 'seller' disk if exists
        try {
            if (Storage::disk('seller')->exists($relPath)) {
                Storage::disk('seller')->delete($relPath);
                $deleted = true;
            }
        } catch (\Throwable $e) {
            Log::warning("SellerMediaService: failed checking/deleting file from seller disk: {$relPath}. Error: " . $e->getMessage());
        }

        // Fallback check on 'public' disk
        try {
            if (Storage::disk('public')->exists($relPath)) {
                Storage::disk('public')->delete($relPath);
                $deleted = true;
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return $deleted;
    }

    /**
     * Safely delete an entire directory from its disk (or both R2 and local seller disk).
     *
     * @param string $directoryPath
     * @param string|null $disk
     * @return bool
     */
    public function deleteDirectory(string $directoryPath, ?string $disk = null): bool
    {
        $relPath = $this->extractRelativePath($directoryPath);
        if (empty($relPath)) {
            return false;
        }

        $deleted = false;

        if ($disk) {
            if ($disk === 'r2') {
                try {
                    $r2Prefixed = $this->prefixR2Path($relPath);
                    Storage::disk('r2')->deleteDirectory($r2Prefixed);
                    if ($r2Prefixed !== $relPath) {
                        Storage::disk('r2')->deleteDirectory($relPath);
                    }
                    return true;
                } catch (\Throwable $e) {
                    Log::warning("SellerMediaService: failed deleting directory from R2: {$relPath}. Error: " . $e->getMessage());
                    return false;
                }
            }

            if (Storage::disk($disk)->exists($relPath)) {
                return Storage::disk($disk)->deleteDirectory($relPath);
            }
            return false;
        }

        // Delete from R2 (both prefixed and raw)
        try {
            $r2Prefixed = $this->prefixR2Path($relPath);
            Storage::disk('r2')->deleteDirectory($r2Prefixed);
            if ($r2Prefixed !== $relPath) {
                Storage::disk('r2')->deleteDirectory($relPath);
            }
            $deleted = true;
        } catch (\Throwable $e) {
            Log::warning("SellerMediaService: failed deleting directory from R2: {$relPath}. Error: " . $e->getMessage());
        }

        // Delete from local seller disk
        try {
            if (Storage::disk('seller')->exists($relPath)) {
                Storage::disk('seller')->deleteDirectory($relPath);
                $deleted = true;
            }
        } catch (\Throwable $e) {
            Log::warning("SellerMediaService: failed deleting directory from seller disk: {$relPath}. Error: " . $e->getMessage());
        }

        // Delete from public disk if applicable
        try {
            if (Storage::disk('public')->exists($relPath)) {
                Storage::disk('public')->deleteDirectory($relPath);
                $deleted = true;
            } elseif (Storage::disk('public')->exists('seller/' . $relPath)) {
                Storage::disk('public')->deleteDirectory('seller/' . $relPath);
                $deleted = true;
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return $deleted;
    }

    /**
     * Get the full public URL for a given path and disk.
     *
     * @param string $path
     * @param string|null $disk
     * @return string
     */
    public function getUrl(string $path, ?string $disk = null): string
    {
        $targetDisk = $disk ?? $this->getActiveDisk();

        if ($targetDisk === 'r2') {
            $r2Path = $this->prefixR2Path($path);
            $r2PublicUrl = rtrim((string) config('filesystems.disks.r2.url', ''), '/');
            if (!empty($r2PublicUrl)) {
                return $r2PublicUrl . '/' . ltrim($r2Path, '/');
            }
            return Storage::disk('r2')->url($r2Path);
        }

        // Local 'seller' disk (storage/app/public/seller)
        return Storage::disk('seller')->url('app/public/seller/' . ltrim($path, '/'));
    }

    /**
     * Safely download a seller digital file using dual-check logic (R2 then Local).
     *
     * @param string $filePath Path relative to disk root
     * @param string|null $name Optional download filename
     * @param array $headers
     * @return StreamedResponse|null
     */
    public function downloadDigitalFile(string $filePath, ?string $name = null, array $headers = []): ?StreamedResponse
    {
        $downloadName = $name ?: basename($filePath);
        $r2Prefixed = $this->prefixR2Path($filePath);

        // 1. Check Cloudflare R2 disk with 'seller/' prefix
        if (Storage::disk('r2')->exists($r2Prefixed)) {
            return Storage::disk('r2')->download($r2Prefixed, $downloadName, $headers);
        }

        // 2. Check Cloudflare R2 without prefix (legacy fallback)
        if (Storage::disk('r2')->exists($filePath)) {
            return Storage::disk('r2')->download($filePath, $downloadName, $headers);
        }

        // 3. Check Cloudflare R2 private bucket if configured
        if (Storage::disk('r2_private')->exists($r2Prefixed)) {
            return Storage::disk('r2_private')->download($r2Prefixed, $downloadName, $headers);
        } elseif (Storage::disk('r2_private')->exists($filePath)) {
            return Storage::disk('r2_private')->download($filePath, $downloadName, $headers);
        }

        // 4. Fallback to Local 'seller' disk
        if (Storage::disk('seller')->exists($filePath)) {
            return Storage::disk('seller')->download($filePath, $downloadName, $headers);
        }

        return null;
    }

    /**
     * Check if a seller digital file exists on Cloudflare R2 or local disk using dual-check logic.
     *
     * @param string|null $filePath Path relative to disk root or URL
     * @return bool
     */
    public function hasDigitalFile(?string $filePath): bool
    {
        if (empty($filePath)) {
            return false;
        }

        $cleanPath = $this->extractRelativePath($filePath);
        if (empty($cleanPath)) {
            return false;
        }

        $r2Prefixed = $this->prefixR2Path($cleanPath);

        // 1. Check Cloudflare R2 disk with 'seller/' prefix
        try {
            if (Storage::disk('r2')->exists($r2Prefixed)) {
                return true;
            }
            // 2. Check Cloudflare R2 without prefix (fallback)
            if (Storage::disk('r2')->exists($cleanPath)) {
                return true;
            }
            // 3. Check Cloudflare R2 private bucket if configured
            if (config('filesystems.disks.r2_private') && (Storage::disk('r2_private')->exists($r2Prefixed) || Storage::disk('r2_private')->exists($cleanPath))) {
                return true;
            }
        } catch (\Throwable $e) {
            Log::warning("SellerMediaService::hasDigitalFile R2 check failed for [{$filePath}]: " . $e->getMessage());
        }

        // 4. Fallback to Local 'seller' disk
        try {
            if (Storage::disk('seller')->exists($cleanPath)) {
                return true;
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return false;
    }

    /**
     * Migrate a single file from local storage to Cloudflare R2.
     *
     * @param string $relativePath Path relative to 'seller' disk (e.g. "store/products/1/images/pic.png")
     * @param bool $deleteLocal Whether to delete from local disk after successful R2 upload
     * @return array ['success' => bool, 'r2_url' => string|null, 'r2_path' => string|null, 'bytes' => int, 'message' => string]
     */
    public function migrateLocalFileToR2(string $relativePath, bool $deleteLocal = false): array
    {
        $relativePath = ltrim($relativePath, '/');

        if (!Storage::disk('seller')->exists($relativePath)) {
            return [
                'success' => false,
                'r2_url'  => null,
                'r2_path' => null,
                'bytes'   => 0,
                'message' => "Local file does not exist: {$relativePath}",
            ];
        }

        try {
            $stream = Storage::disk('seller')->readStream($relativePath);
            if ($stream === false) {
                return [
                    'success' => false,
                    'r2_url'  => null,
                    'r2_path' => null,
                    'bytes'   => 0,
                    'message' => "Unable to read local stream for: {$relativePath}",
                ];
            }

            // Write stream to Cloudflare R2 inside 'seller/' folder
            $r2TargetPath = $this->prefixR2Path($relativePath);
            $written = Storage::disk('r2')->writeStream($r2TargetPath, $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }

            if (!$written || !Storage::disk('r2')->exists($r2TargetPath)) {
                return [
                    'success' => false,
                    'r2_url'  => null,
                    'r2_path' => null,
                    'bytes'   => 0,
                    'message' => "Failed to write or verify file on Cloudflare R2: {$r2TargetPath}",
                ];
            }

            $bytes = Storage::disk('seller')->size($relativePath);
            $r2Url = $this->getUrl($r2TargetPath, 'r2');

            if ($deleteLocal) {
                Storage::disk('seller')->delete($relativePath);
            }

            return [
                'success' => true,
                'r2_url'  => $r2Url,
                'r2_path' => $r2TargetPath,
                'bytes'   => $bytes,
                'message' => 'Migrated successfully',
            ];
        } catch (\Throwable $e) {
            Log::error("Migration to R2 failed for {$relativePath}: " . $e->getMessage());
            return [
                'success' => false,
                'r2_url'  => null,
                'r2_path' => null,
                'bytes'   => 0,
                'message' => $e->getMessage(),
            ];
        }
    }
}
