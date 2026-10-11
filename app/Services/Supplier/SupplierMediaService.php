<?php

namespace App\Services\Supplier;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SupplierMediaService
{
    public const R2_PREFIX = 'suppliers';

    /**
     * Ensure a path or directory is prefixed with 'suppliers/' for Cloudflare R2 storage.
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
     * Get the active disk for new supplier uploads ('r2' or 'supplier').
     *
     * @return string
     */
    public function getActiveDisk(): string
    {
        return config('filesystems.supplier_default_disk', 'supplier');
    }

    /**
     * Store an uploaded file on the active supplier disk.
     *
     * @param UploadedFile $file
     * @param string $directory Path relative to disk
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
     * Extract clean relative path from any full URL or stored path for supplier media.
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
            'storage/tenantsupplier/app/public/',
            'storage/tenantsupplier/',
            'tenantsupplier/app/public/',
            'tenantsupplier/',
            'storage/app/public/',
            'storage/',
            'app/public/',
            'supplier/',
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
     * Safely delete a file from its disk (or both R2, supplier, and public disks if unknown).
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

        // Check and delete from R2 if exists (both prefixed and legacy)
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
            Log::warning("SupplierMediaService: failed checking/deleting file from R2: {$relPath}. Error: " . $e->getMessage());
        }

        // Check and delete from local 'supplier' disk if exists
        try {
            if (Storage::disk('supplier')->exists($relPath)) {
                Storage::disk('supplier')->delete($relPath);
                $deleted = true;
            }
        } catch (\Throwable $e) {
            Log::warning("SupplierMediaService: failed checking/deleting file from supplier disk: {$relPath}. Error: " . $e->getMessage());
        }

        // Check and delete from 'public' disk if exists
        try {
            if (Storage::disk('public')->exists($relPath)) {
                Storage::disk('public')->delete($relPath);
                $deleted = true;
            } elseif (Storage::disk('public')->exists('supplier/' . $relPath)) {
                Storage::disk('public')->delete('supplier/' . $relPath);
                $deleted = true;
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return $deleted;
    }

    /**
     * Safely delete an entire directory from its disk (or both R2, supplier, and public disks).
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
                    Log::warning("SupplierMediaService: failed deleting directory from R2: {$relPath}. Error: " . $e->getMessage());
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
            Log::warning("SupplierMediaService: failed deleting directory from R2: {$relPath}. Error: " . $e->getMessage());
        }

        // Delete from local supplier disk
        try {
            if (Storage::disk('supplier')->exists($relPath)) {
                Storage::disk('supplier')->deleteDirectory($relPath);
                $deleted = true;
            }
        } catch (\Throwable $e) {
            Log::warning("SupplierMediaService: failed deleting directory from supplier disk: {$relPath}. Error: " . $e->getMessage());
        }

        // Delete from public disk if applicable
        try {
            if (Storage::disk('public')->exists($relPath)) {
                Storage::disk('public')->deleteDirectory($relPath);
                $deleted = true;
            } elseif (Storage::disk('public')->exists('supplier/' . $relPath)) {
                Storage::disk('public')->deleteDirectory('supplier/' . $relPath);
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

        // Local 'supplier' disk (storage/tenantsupplier)
        return Storage::disk('supplier')->url('tenantsupplier/' . ltrim($path, '/'));
    }

    /**
     * Migrate a single file from local storage (supplier or public disk) to Cloudflare R2.
     *
     * @param string $relativePath
     * @param bool $deleteLocal
     * @param string $sourceDisk
     * @return array ['success' => bool, 'r2_url' => string|null, 'r2_path' => string|null, 'bytes' => int, 'message' => string]
     */
    public function migrateLocalFileToR2(string $relativePath, bool $deleteLocal = false, string $sourceDisk = 'supplier'): array
    {
        $relativePath = ltrim($relativePath, '/');

        // Determine which local disk actually holds the file
        $diskToRead = null;
        if (Storage::disk($sourceDisk)->exists($relativePath)) {
            $diskToRead = $sourceDisk;
        } elseif (Storage::disk('supplier')->exists($relativePath)) {
            $diskToRead = 'supplier';
        } elseif (Storage::disk('public')->exists($relativePath)) {
            $diskToRead = 'public';
        }

        if (!$diskToRead) {
            return [
                'success' => false,
                'r2_url'  => null,
                'r2_path' => null,
                'bytes'   => 0,
                'message' => "Local file does not exist: {$relativePath}",
            ];
        }

        try {
            $stream = Storage::disk($diskToRead)->readStream($relativePath);
            if ($stream === false) {
                return [
                    'success' => false,
                    'r2_url'  => null,
                    'r2_path' => null,
                    'bytes'   => 0,
                    'message' => "Unable to read local stream for: {$relativePath}",
                ];
            }

            // Write stream to Cloudflare R2 inside 'suppliers/' folder
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

            $bytes = Storage::disk($diskToRead)->size($relativePath);
            $r2Url = $this->getUrl($r2TargetPath, 'r2');

            if ($deleteLocal) {
                Storage::disk($diskToRead)->delete($relativePath);
            }

            return [
                'success' => true,
                'r2_url'  => $r2Url,
                'r2_path' => $r2TargetPath,
                'bytes'   => $bytes,
                'message' => 'Migrated successfully',
            ];
        } catch (\Throwable $e) {
            Log::error("Migration to R2 failed for supplier file {$relativePath}: " . $e->getMessage());
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
