<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\DisputeMessage;
use App\Models\DisputesArchive;
use App\Models\PaymentsProofsRefusedsArchive;
use App\Models\ProofsRefusedMessage;
use App\Models\SupportTicketReply;
use App\Services\Admins\Admin\AdminMediaService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateAdminMediaToR2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:migrate-r2
                            {--type=all : File category to migrate: all, proofs, archives, disputes, tickets, employees}
                            {--limit= : Limit the number of records to process per category}
                            {--dry-run : Preview files to migrate without actually uploading to R2}
                            {--delete-local : Delete local file from server after verifying R2 upload to free space}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely migrate platform Admin media (proofs, dispute attachments, ticket replies, employee photos) to Cloudflare R2 with optional local deletion';

    public function handle(AdminMediaService $mediaService): int
    {
        $limitOption = $this->option('limit') ? (int) $this->option('limit') : null;
        $dryRun = (bool) $this->option('dry-run');
        $deleteLocal = (bool) $this->option('delete-local');
        $typeOption = strtolower((string) $this->option('type'));

        $this->info('===========================================================');
        $this->info('      Cloudflare R2 - Admin Media Safe Migration Tool      ');
        $this->info('===========================================================');

        if ($dryRun) {
            $this->warn(' [DRY-RUN MODE] Preview only: No files will be uploaded or deleted.');
        }

        if ($deleteLocal && !$dryRun) {
            $this->warn(' [NOTICE] --delete-local is ACTIVE: Local files will be deleted after verified R2 upload.');
        }

        // Verify R2 configuration
        if (!$dryRun) {
            $r2Bucket = config('filesystems.disks.r2.bucket');
            $r2Key = config('filesystems.disks.r2.key');
            if (empty($r2Bucket) || empty($r2Key)) {
                $this->error('Cloudflare R2 is not configured in .env (R2_BUCKET or R2_ACCESS_KEY_ID is missing).');
                $this->line('Please add your Cloudflare R2 credentials to .env before running this command.');
                return 1;
            }
        }

        $totalMigratedFiles = 0;
        $totalBytes = 0;
        $failedFiles = 0;
        $skippedFiles = 0;

        // 1. Migrate Payment Proofs Chat Attachments (ProofsRefusedMessage)
        if (in_array($typeOption, ['all', 'proofs'])) {
            $this->line('');
            $this->info('--> [1/5] Processing Payment Proofs Refused Chat Attachments...');
            $query = ProofsRefusedMessage::whereNotNull('attachments');
            if ($limitOption) {
                $query->limit($limitOption);
            }
            $messages = $query->get();

            foreach ($messages as $msg) {
                $attachments = is_array($msg->attachments) ? $msg->attachments : json_decode((string) $msg->attachments, true);
                if (empty($attachments) || !is_array($attachments)) {
                    continue;
                }

                $updated = false;
                $newAttachments = [];

                foreach ($attachments as $attPath) {
                    $localPath = $mediaService->extractRelativePath($attPath);
                    if ($this->isAlreadyOnR2($attPath, $mediaService)) {
                        $newAttachments[] = $attPath;
                        $skippedFiles++;
                        continue;
                    }

                    if ($localPath && $mediaService->exists($localPath)) {
                        if ($dryRun) {
                            $size = $this->getLocalFileSize($localPath, $mediaService);
                            $this->line("    [DRY-RUN] Proof chat #{$msg->id}: {$localPath} (" . $this->formatBytes($size) . ')');
                            $totalMigratedFiles++;
                            $totalBytes += $size;
                            $newAttachments[] = $attPath;
                        } else {
                            $res = $mediaService->migrateLocalFileToR2($localPath, $deleteLocal);
                            if ($res['success']) {
                                $newAttachments[] = $res['r2_path'];
                                $totalMigratedFiles++;
                                $totalBytes += $res['bytes'];
                                $updated = true;
                                $this->info("    [OK] Proof chat #{$msg->id}: {$localPath} -> R2 ({$res['found_disk']})");
                            } else {
                                $newAttachments[] = $attPath;
                                $failedFiles++;
                                $this->error("    [FAIL] Proof chat #{$msg->id}: {$res['message']}");
                            }
                        }
                    } else {
                        $newAttachments[] = $attPath;
                        $skippedFiles++;
                    }
                }

                if ($updated && !$dryRun) {
                    $msg->attachments = $newAttachments;
                    $msg->save();
                }
            }
        }

        // 2. Migrate Payment Proofs Refused Archives (PDFs)
        if (in_array($typeOption, ['all', 'proofs', 'archives'])) {
            $this->line('');
            $this->info('--> [2/5] Processing Payment Proofs Refused PDF Archives...');
            $query = PaymentsProofsRefusedsArchive::query();
            if ($limitOption) {
                $query->limit($limitOption);
            }
            $archives = $query->get();

            foreach ($archives as $archive) {
                $year = $archive->created_at ? $archive->created_at->format('Y') : date('Y');
                $month = $archive->created_at ? $archive->created_at->format('m') : date('m');
                $pdfPath = "archives/proofs-refused/{$year}/{$month}/proof_refused_{$archive->order_number}.pdf";

                if ($this->isAlreadyOnR2($archive->archive_pdf_path, $mediaService)) {
                    $skippedFiles++;
                    continue;
                }

                if ($mediaService->exists($pdfPath)) {
                    if ($dryRun) {
                        $size = $this->getLocalFileSize($pdfPath, $mediaService);
                        $this->line("    [DRY-RUN] Archive #{$archive->id} PDF: {$pdfPath} (" . $this->formatBytes($size) . ')');
                        $totalMigratedFiles++;
                        $totalBytes += $size;
                    } else {
                        $res = $mediaService->migrateLocalFileToR2($pdfPath, $deleteLocal);
                        if ($res['success']) {
                            $archive->archive_pdf_path = $res['r2_path'];
                            $archive->save();
                            $totalMigratedFiles++;
                            $totalBytes += $res['bytes'];
                            $this->info("    [OK] Archive #{$archive->id} PDF: {$pdfPath}");
                        } else {
                            $failedFiles++;
                            $this->error("    [FAIL] Archive #{$archive->id} PDF: {$res['message']}");
                        }
                    }
                } else {
                    $skippedFiles++;
                }
            }
        }

        // 3. Migrate Dispute Messages & Dispute Archives
        if (in_array($typeOption, ['all', 'disputes'])) {
            $this->line('');
            $this->info('--> [3/5] Processing Dispute Messages Attachments & Dispute Archives...');

            // 3a. Dispute Messages
            $query = DisputeMessage::whereNotNull('attachments');
            if ($limitOption) {
                $query->limit($limitOption);
            }
            $disputeMessages = $query->get();

            foreach ($disputeMessages as $dMsg) {
                $attachments = is_array($dMsg->attachments) ? $dMsg->attachments : json_decode((string) $dMsg->attachments, true);
                if (empty($attachments) || !is_array($attachments)) {
                    continue;
                }

                $updated = false;
                $newAttachments = [];

                foreach ($attachments as $attPath) {
                    $localPath = $mediaService->extractRelativePath($attPath);
                    if ($this->isAlreadyOnR2($attPath, $mediaService)) {
                        $newAttachments[] = $attPath;
                        $skippedFiles++;
                        continue;
                    }

                    if ($localPath && $mediaService->exists($localPath)) {
                        if ($dryRun) {
                            $size = $this->getLocalFileSize($localPath, $mediaService);
                            $this->line("    [DRY-RUN] Dispute Msg #{$dMsg->id}: {$localPath} (" . $this->formatBytes($size) . ')');
                            $totalMigratedFiles++;
                            $totalBytes += $size;
                            $newAttachments[] = $attPath;
                        } else {
                            $res = $mediaService->migrateLocalFileToR2($localPath, $deleteLocal);
                            if ($res['success']) {
                                $newAttachments[] = $res['r2_path'];
                                $totalMigratedFiles++;
                                $totalBytes += $res['bytes'];
                                $updated = true;
                                $this->info("    [OK] Dispute Msg #{$dMsg->id}: {$localPath}");
                            } else {
                                $newAttachments[] = $attPath;
                                $failedFiles++;
                                $this->error("    [FAIL] Dispute Msg #{$dMsg->id}: {$res['message']}");
                            }
                        }
                    } else {
                        $newAttachments[] = $attPath;
                        $skippedFiles++;
                    }
                }

                if ($updated && !$dryRun) {
                    $dMsg->attachments = $newAttachments;
                    $dMsg->save();
                }
            }

            // 3b. Disputes Archives (PDFs)
            $dArchivesQuery = DisputesArchive::whereNotNull('file_path');
            if ($limitOption) {
                $dArchivesQuery->limit($limitOption);
            }
            $dArchives = $dArchivesQuery->get();

            foreach ($dArchives as $dArchive) {
                $localPath = $mediaService->extractRelativePath($dArchive->file_path);
                if ($this->isAlreadyOnR2($dArchive->file_path, $mediaService)) {
                    $skippedFiles++;
                    continue;
                }

                if ($localPath && $mediaService->exists($localPath)) {
                    if ($dryRun) {
                        $size = $this->getLocalFileSize($localPath, $mediaService);
                        $this->line("    [DRY-RUN] Dispute Archive #{$dArchive->id}: {$localPath} (" . $this->formatBytes($size) . ')');
                        $totalMigratedFiles++;
                        $totalBytes += $size;
                    } else {
                        $res = $mediaService->migrateLocalFileToR2($localPath, $deleteLocal);
                        if ($res['success']) {
                            $dArchive->file_path = $res['r2_path'];
                            $dArchive->save();
                            $totalMigratedFiles++;
                            $totalBytes += $res['bytes'];
                            $this->info("    [OK] Dispute Archive #{$dArchive->id}: {$localPath}");
                        } else {
                            $failedFiles++;
                            $this->error("    [FAIL] Dispute Archive #{$dArchive->id}: {$res['message']}");
                        }
                    }
                } else {
                    $skippedFiles++;
                }
            }
        }

        // 4. Migrate Support Ticket Replies Attachments
        if (in_array($typeOption, ['all', 'tickets'])) {
            $this->line('');
            $this->info('--> [4/5] Processing Support Ticket Replies Attachments...');
            $query = SupportTicketReply::whereNotNull('attachments');
            if ($limitOption) {
                $query->limit($limitOption);
            }
            $replies = $query->get();

            foreach ($replies as $reply) {
                $attachments = is_array($reply->attachments) ? $reply->attachments : json_decode((string) $reply->attachments, true);
                if (empty($attachments) || !is_array($attachments)) {
                    continue;
                }

                $updated = false;
                $newAttachments = [];

                foreach ($attachments as $attPath) {
                    $localPath = $mediaService->extractRelativePath($attPath);
                    if ($this->isAlreadyOnR2($attPath, $mediaService)) {
                        $newAttachments[] = $attPath;
                        $skippedFiles++;
                        continue;
                    }

                    if ($localPath && $mediaService->exists($localPath)) {
                        if ($dryRun) {
                            $size = $this->getLocalFileSize($localPath, $mediaService);
                            $this->line("    [DRY-RUN] Ticket Reply #{$reply->id}: {$localPath} (" . $this->formatBytes($size) . ')');
                            $totalMigratedFiles++;
                            $totalBytes += $size;
                            $newAttachments[] = $attPath;
                        } else {
                            $res = $mediaService->migrateLocalFileToR2($localPath, $deleteLocal);
                            if ($res['success']) {
                                $newAttachments[] = $res['r2_path'];
                                $totalMigratedFiles++;
                                $totalBytes += $res['bytes'];
                                $updated = true;
                                $this->info("    [OK] Ticket Reply #{$reply->id}: {$localPath}");
                            } else {
                                $newAttachments[] = $attPath;
                                $failedFiles++;
                                $this->error("    [FAIL] Ticket Reply #{$reply->id}: {$res['message']}");
                            }
                        }
                    } else {
                        $newAttachments[] = $attPath;
                        $skippedFiles++;
                    }
                }

                if ($updated && !$dryRun) {
                    $reply->attachments = $newAttachments;
                    $reply->save();
                }
            }
        }

        // 5. Migrate Admin Employee Avatars/Photos
        if (in_array($typeOption, ['all', 'employees'])) {
            $this->line('');
            $this->info('--> [5/5] Processing Admin Employees Photos...');

            // 5a. If photo column exists in admins table
            if (\Illuminate\Support\Facades\Schema::hasColumn('admins', 'photo')) {
                $query = Admin::whereNotNull('photo');
                if ($limitOption) {
                    $query->limit($limitOption);
                }
                $employees = $query->get();

                foreach ($employees as $employee) {
                    $localPath = $mediaService->extractRelativePath($employee->photo);
                    if ($this->isAlreadyOnR2($employee->photo, $mediaService)) {
                        $skippedFiles++;
                        continue;
                    }

                    if ($localPath && $mediaService->exists($localPath)) {
                        if ($dryRun) {
                            $size = $this->getLocalFileSize($localPath, $mediaService);
                            $this->line("    [DRY-RUN] Employee #{$employee->id} ({$employee->name}): {$localPath} (" . $this->formatBytes($size) . ')');
                            $totalMigratedFiles++;
                            $totalBytes += $size;
                        } else {
                            $res = $mediaService->migrateLocalFileToR2($localPath, $deleteLocal, 'employees');
                            if ($res['success']) {
                                $employee->photo = $res['r2_path'];
                                $employee->save();
                                $totalMigratedFiles++;
                                $totalBytes += $res['bytes'];
                                $this->info("    [OK] Employee #{$employee->id} ({$employee->name}): {$localPath}");
                            } else {
                                $failedFiles++;
                                $this->error("    [FAIL] Employee #{$employee->id}: {$res['message']}");
                            }
                        }
                    } else {
                        $skippedFiles++;
                    }
                }
            }

            // 5b. Scan disk 'employees' for any uploaded avatar files
            try {
                $employeeFiles = Storage::disk('employees')->allFiles();
                if ($limitOption) {
                    $employeeFiles = array_slice($employeeFiles, 0, $limitOption);
                }
                foreach ($employeeFiles as $eFile) {
                    if ($this->isAlreadyOnR2($eFile, $mediaService)) {
                        $skippedFiles++;
                        continue;
                    }

                    if ($dryRun) {
                        $size = Storage::disk('employees')->size($eFile);
                        $this->line("    [DRY-RUN] Employee Disk File: {$eFile} (" . $this->formatBytes($size) . ')');
                        $totalMigratedFiles++;
                        $totalBytes += $size;
                    } else {
                        $res = $mediaService->migrateLocalFileToR2($eFile, $deleteLocal, 'employees');
                        if ($res['success']) {
                            $totalMigratedFiles++;
                            $totalBytes += $res['bytes'];
                            $this->info("    [OK] Employee Disk File: {$eFile}");
                        } else {
                            $failedFiles++;
                            $this->error("    [FAIL] Employee Disk File: {$res['message']}");
                        }
                    }
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }


        $this->line('');
        $this->info('===========================================================');
        $this->info('              Admin Media Migration Summary                ');
        $this->info('===========================================================');
        $this->line(" Total Files Processed/Migrated : {$totalMigratedFiles}");
        $this->line(" Total Size Transferred        : " . $this->formatBytes($totalBytes));
        if ($deleteLocal && !$dryRun) {
            $this->line(" Local Disk Space Freed        : <fg=green>" . $this->formatBytes($totalBytes) . '</>');
        }
        $this->line(" Skipped (Already on R2/Missing): {$skippedFiles}");
        if ($failedFiles > 0) {
            $this->error(" Failed Files                   : {$failedFiles}");
        } else {
            $this->info(" Failed Files                   : 0 (All Success)");
        }
        $this->info('===========================================================');

        return 0;
    }

    /**
     * Check if path is already uploaded and pointing to Cloudflare R2.
     */
    protected function isAlreadyOnR2(?string $path, AdminMediaService $mediaService): bool
    {
        if (empty($path)) {
            return false;
        }

        $r2PublicUrl = rtrim((string) config('filesystems.disks.r2.url', ''), '/');
        if (!empty($r2PublicUrl) && str_starts_with($path, $r2PublicUrl)) {
            return true;
        }

        if (str_starts_with($path, AdminMediaService::R2_PREFIX . '/')) {
            return true;
        }

        return false;
    }

    /**
     * Get size of local file from fallback disks.
     */
    protected function getLocalFileSize(string $relativePath, AdminMediaService $mediaService): int
    {
        $disks = ['general', 'employees', 'public', 'local'];
        foreach ($disks as $disk) {
            try {
                if (Storage::disk($disk)->exists($relativePath)) {
                    return Storage::disk($disk)->size($relativePath);
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }
        return 0;
    }

    /**
     * Format bytes to human readable format.
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
