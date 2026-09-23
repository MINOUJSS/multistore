<?php

namespace App\Console\Commands;

use App\Services\Platform\StoreVisitorsReportService;
use Illuminate\Console\Command;

class SendStoreVisitorsReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:send-visitors-report 
                            {frequency=daily : The frequency of the report (daily, weekly, monthly)} 
                            {--role=all : The target role (all, seller, supplier)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send periodic store visitors analytics report with actionable insights via Telegram to sellers and suppliers';

    /**
     * Execute the console command.
     */
    public function handle(StoreVisitorsReportService $reportService): int
    {
        $frequency = strtolower($this->argument('frequency') ?? 'daily');
        $role = strtolower($this->option('role') ?? 'all');

        if (!in_array($frequency, ['daily', 'weekly', 'monthly'])) {
            $this->error("Invalid frequency '{$frequency}'. Allowed values: daily, weekly, monthly.");
            return Command::FAILURE;
        }

        if (!in_array($role, ['all', 'seller', 'supplier'])) {
            $this->error("Invalid role '{$role}'. Allowed values: all, seller, supplier.");
            return Command::FAILURE;
        }

        $this->info("🚀 Starting {$frequency} store visitors report for role: {$role}...");

        $results = $reportService->sendReports($frequency, $role);

        $this->table(
            ['Frequency', 'Target Role', 'Total Subscribers', 'Sent', 'Failed', 'Skipped'],
            [[
                $results['frequency'],
                $results['role'],
                $results['total_subscribers'],
                $results['sent_count'],
                $results['failed_count'],
                $results['skipped_count'],
            ]]
        );

        if (!empty($results['details'])) {
            $rows = [];
            foreach ($results['details'] as $detail) {
                $rows[] = [
                    $detail['store_name'] ?? ($detail['user_id'] ?? '-'),
                    $detail['role'] ?? '-',
                    $detail['status'],
                    $detail['current_visits'] ?? '-',
                    $detail['previous_visits'] ?? '-',
                    $detail['reason'] ?? 'OK',
                ];
            }

            $this->line("\nSubscribers Details:");
            $this->table(['Store/User', 'Role', 'Status', 'Current Visits', 'Previous Visits', 'Note'], $rows);
        }

        $this->info("✅ Finished {$frequency} store visitors report.");

        return Command::SUCCESS;
    }
}
