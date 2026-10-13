<?php

namespace App\Services\Admins\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminMediaService
{
    public const R2_PREFIX = 'admin';

    /**
     * Fallback disks to check for legacy local files.
     */
    protected array $fallbackDisks = ['general', 'public', 'employees', 'local'];

    /**
     * Get the active disk configured for Admin storage ('general' or 'r2').
     *
     * @return string
     */
    public function getActiveDisk(): string
    {
        return config('filesystems.admin_default_disk', 'general');
    }

    /**
     * Ensure a path is prefixed with 'admin/' when saving to Cloudflare R2.
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
     * Extract clean relative path from any full URL or legacy local stored path.
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
            'storage/app/public/',
            'storage/general/',
            'storage/employees/',
            'app/public/',
            'general/',
            'employees/',
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
     * Store an uploaded file on the active admin disk.
     *
     * @param UploadedFile $file
     * @param string $directory Path relative to disk (e.g. "proofs_refused_chats/12/admin")
     * @param string|null $disk
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
     * Store raw contents (e.g., generated PDF strings, text) on the active disk.
     *
     * @param string $path
     * @param mixed $contents
     * @param string|null $disk
     * @param array $options
     * @return bool|string
     */
    public function put(string $path, $contents, ?string $disk = null, array $options = [])
    {
        $targetDisk = $disk ?? $this->getActiveDisk();
        $targetPath = $targetDisk === 'r2' ? $this->prefixR2Path($path) : $path;

        $saved = Storage::disk($targetDisk)->put($targetPath, $contents, $options);
        return $saved ? $targetPath : false;
    }

    /**
     * Check if a file exists (dual-checking R2 and legacy local disks).
     *
     * @param string $path
     * @param string|null $disk
     * @return bool
     */
    public function exists(string $path, ?string $disk = null): bool
    {
        $relPath = $this->extractRelativePath($path);

        if ($disk) {
            $checkPath = $disk === 'r2' ? $this->prefixR2Path($relPath) : $relPath;
            return Storage::disk($disk)->exists($checkPath);
        }

        // 1. Check R2 if active or configured
        try {
            $r2Path = $this->prefixR2Path($relPath);
            if (Storage::disk('r2')->exists($r2Path) || Storage::disk('r2')->exists($relPath)) {
                return true;
            }
        } catch (\Throwable $e) {
            // R2 unavailable or unconfigured, proceed to local disks
        }

        // 2. Check fallback local disks
        foreach ($this->fallbackDisks as $fDisk) {
            try {
                if (Storage::disk($fDisk)->exists($relPath)) {
                    return true;
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        return false;
    }

    /**
     * Get contents of a file (dual-checking R2 and fallback disks).
     *
     * @param string $path
     * @param string|null $disk
     * @return string|null
     */
    public function get(string $path, ?string $disk = null): ?string
    {
        $relPath = $this->extractRelativePath($path);

        if ($disk) {
            $checkPath = $disk === 'r2' ? $this->prefixR2Path($relPath) : $relPath;
            return Storage::disk($disk)->get($checkPath);
        }

        // Check R2
        try {
            $r2Path = $this->prefixR2Path($relPath);
            if (Storage::disk('r2')->exists($r2Path)) {
                return Storage::disk('r2')->get($r2Path);
            }
            if (Storage::disk('r2')->exists($relPath)) {
                return Storage::disk('r2')->get($relPath);
            }
        } catch (\Throwable $e) {
            // ignore
        }

        // Check fallback disks
        foreach ($this->fallbackDisks as $fDisk) {
            try {
                if (Storage::disk($fDisk)->exists($relPath)) {
                    return Storage::disk($fDisk)->get($relPath);
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        return null;
    }

    /**
     * Resolve the full public URL for a file.
     *
     * @param string $path
     * @param string|null $disk
     * @return string
     */
    public function getUrl(string $path, ?string $disk = null): string
    {
        $cleanPath = trim($path);
        if (filter_var($cleanPath, FILTER_VALIDATE_URL) || str_starts_with($cleanPath, 'http://') || str_starts_with($cleanPath, 'https://')) {
            return $cleanPath;
        }

        $relPath = $this->extractRelativePath($cleanPath);
        $targetDisk = $disk ?? $this->getActiveDisk();

        // 1. If explicitly R2 or file is on R2
        if ($targetDisk === 'r2') {
            $r2Path = $this->prefixR2Path($relPath);
            $r2PublicUrl = rtrim((string) config('filesystems.disks.r2.url', ''), '/');
            if (!empty($r2PublicUrl)) {
                return $r2PublicUrl . '/' . ltrim($r2Path, '/');
            }
            try {
                return Storage::disk('r2')->url($r2Path);
            } catch (\Throwable $e) {
                // fallback to app url
            }
        }

        // Check if file exists on R2 dynamically
        try {
            $r2Path = $this->prefixR2Path($relPath);
            if (Storage::disk('r2')->exists($r2Path)) {
                $r2PublicUrl = rtrim((string) config('filesystems.disks.r2.url', ''), '/');
                if (!empty($r2PublicUrl)) {
                    return $r2PublicUrl . '/' . ltrim($r2Path, '/');
                }
                return Storage::disk('r2')->url($r2Path);
            }
        } catch (\Throwable $e) {
            // ignore
        }

        // 2. Fallback to local disks
        if (Storage::disk('general')->exists($relPath)) {
            return asset('storage/general/' . $relPath);
        }

        if (Storage::disk('employees')->exists($relPath)) {
            return asset('storage/employees/' . $relPath);
        }

        return asset('storage/' . $relPath);
    }

    /**
     * Download an admin file safely (supports dual-check between R2 and Local).
     *
     * @param string $filePath
     * @param string|null $name Optional filename
     * @param array $headers
     * @return StreamedResponse|null
     */
    public function download(string $filePath, ?string $name = null, array $headers = []): ?StreamedResponse
    {
        $relPath = $this->extractRelativePath($filePath);
        $downloadName = $name ?: basename($relPath);

        // 1. Check R2 first
        try {
            $r2Path = $this->prefixR2Path($relPath);
            if (Storage::disk('r2')->exists($r2Path)) {
                return Storage::disk('r2')->download($r2Path, $downloadName, $headers);
            }
            if (Storage::disk('r2')->exists($relPath)) {
                return Storage::disk('r2')->download($relPath, $downloadName, $headers);
            }
        } catch (\Throwable $e) {
            Log::warning("AdminMediaService: error downloading from R2: " . $e->getMessage());
        }

        // 2. Check local fallback disks
        foreach ($this->fallbackDisks as $fDisk) {
            try {
                if (Storage::disk($fDisk)->exists($relPath)) {
                    return Storage::disk($fDisk)->download($relPath, $downloadName, $headers);
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        return null;
    }

    /**
     * Safely delete a file from active disk and local fallbacks.
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

        // Delete from R2
        try {
            $r2Prefixed = $this->prefixR2Path($relPath);
            if (Storage::disk('r2')->exists($r2Prefixed)) {
                Storage::disk('r2')->delete($r2Prefixed);
                $deleted = true;
            }
            if (Storage::disk('r2')->exists($relPath)) {
                Storage::disk('r2')->delete($relPath);
                $deleted = true;
            }
        } catch (\Throwable $e) {
            Log::warning("AdminMediaService: error deleting from R2: {$relPath}. Error: " . $e->getMessage());
        }

        // Delete from fallback local disks
        foreach ($this->fallbackDisks as $fDisk) {
            try {
                if (Storage::disk($fDisk)->exists($relPath)) {
                    Storage::disk($fDisk)->delete($relPath);
                    $deleted = true;
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        return $deleted;
    }

    /**
     * Safely delete an entire directory from active disk and local fallbacks.
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

        // Delete from R2
        try {
            $r2Prefixed = $this->prefixR2Path($relPath);
            Storage::disk('r2')->deleteDirectory($r2Prefixed);
            if ($r2Prefixed !== $relPath) {
                Storage::disk('r2')->deleteDirectory($relPath);
            }
            $deleted = true;
        } catch (\Throwable $e) {
            Log::warning("AdminMediaService: error deleting directory from R2: {$relPath}. Error: " . $e->getMessage());
        }

        // Delete from fallback local disks
        foreach ($this->fallbackDisks as $fDisk) {
            try {
                if (Storage::disk($fDisk)->exists($relPath)) {
                    Storage::disk($fDisk)->deleteDirectory($relPath);
                    $deleted = true;
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        return $deleted;
    }

    /**
     * Get list of files in a directory (checking R2 first, then active/fallback disks).
     *
     * @param string $directory
     * @param string|null $disk
     * @return array
     */
    public function files(string $directory, ?string $disk = null): array
    {
        $targetDisk = $disk ?? $this->getActiveDisk();
        $relPath = $this->extractRelativePath($directory);

        if ($targetDisk === 'r2') {
            try {
                $r2Path = $this->prefixR2Path($relPath);
                return Storage::disk('r2')->files($r2Path);
            } catch (\Throwable $e) {
                // fallback
            }
        }

        if (Storage::disk($targetDisk)->exists($relPath)) {
            return Storage::disk($targetDisk)->files($relPath);
        }

        foreach ($this->fallbackDisks as $fDisk) {
            try {
                if (Storage::disk($fDisk)->exists($relPath)) {
                    return Storage::disk($fDisk)->files($relPath);
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        return [];
    }

    /**
     * Safely migrate a local file to Cloudflare R2 and optionally delete local copy after verification.
     *
     * @param string $relativePath
     * @param bool $deleteLocal
     * @param string|null $sourceDisk
     * @return array ['success' => bool, 'r2_url' => ?string, 'r2_path' => ?string, 'bytes' => int, 'message' => string]
     */
    public function migrateLocalFileToR2(string $relativePath, bool $deleteLocal = false, ?string $sourceDisk = null): array
    {
        $cleanPath = $this->extractRelativePath($relativePath);

        // Find which disk actually holds the local file
        $foundDisk = null;
        if ($sourceDisk && Storage::disk($sourceDisk)->exists($cleanPath)) {
            $foundDisk = $sourceDisk;
        } else {
            foreach ($this->fallbackDisks as $fDisk) {
                if (Storage::disk($fDisk)->exists($cleanPath)) {
                    $foundDisk = $fDisk;
                    break;
                }
            }
        }

        if (!$foundDisk) {
            return [
                'success' => false,
                'r2_url'  => null,
                'r2_path' => null,
                'bytes'   => 0,
                'message' => "Local file does not exist on any local disk: {$cleanPath}",
            ];
        }

        try {
            $stream = Storage::disk($foundDisk)->readStream($cleanPath);
            if ($stream === false) {
                return [
                    'success' => false,
                    'r2_url'  => null,
                    'r2_path' => null,
                    'bytes'   => 0,
                    'message' => "Unable to read local stream for: {$cleanPath} from disk: {$foundDisk}",
                ];
            }

            // Write stream to Cloudflare R2 inside 'admin/' folder
            $r2TargetPath = $this->prefixR2Path($cleanPath);
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

            $bytes = Storage::disk($foundDisk)->size($cleanPath);
            $r2Url = $this->getUrl($r2TargetPath, 'r2');

            // Delete local copy only after verified R2 existence
            if ($deleteLocal) {
                Storage::disk($foundDisk)->delete($cleanPath);
            }

            return [
                'success'    => true,
                'r2_url'     => $r2Url,
                'r2_path'    => $r2TargetPath,
                'bytes'      => $bytes,
                'found_disk' => $foundDisk,
                'message'    => 'Migrated successfully',
            ];
        } catch (\Throwable $e) {
            Log::error("AdminMediaService: Migration to R2 failed for {$cleanPath}: " . $e->getMessage());
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

