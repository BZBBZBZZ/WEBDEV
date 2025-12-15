<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ShowQueueJobs extends Command
{
    protected $signature = 'queue:show';
    protected $description = 'Show pending and failed queue jobs';

    public function handle()
    {
        // Show pending jobs
        $this->info('📋 Pending Jobs:');
        $pendingJobs = DB::table('jobs')->orderBy('created_at', 'desc')->get();
        
        if ($pendingJobs->count() > 0) {
            $this->table(
                ['ID', 'Queue', 'Payload (shortened)', 'Attempts', 'Created At'],
                $pendingJobs->map(function ($job) {
                    $payload = json_decode($job->payload, true);
                    $displayName = $payload['displayName'] ?? 'Unknown';
                    return [
                        $job->id,
                        $job->queue,
                        substr($displayName, 0, 50),
                        $job->attempts,
                        date('H:i:s', $job->created_at)
                    ];
                })
            );
        } else {
            $this->line('  No pending jobs');
        }

        $this->newLine();

        // Show failed jobs
        $this->error('❌ Failed Jobs:');
        $failedJobs = DB::table('failed_jobs')->orderBy('failed_at', 'desc')->limit(5)->get();
        
        if ($failedJobs->count() > 0) {
            $this->table(
                ['ID', 'Connection', 'Queue', 'Failed At'],
                $failedJobs->map(function ($job) {
                    return [
                        $job->id,
                        $job->connection,
                        $job->queue,
                        $job->failed_at
                    ];
                })
            );
        } else {
            $this->line('  No failed jobs');
        }

        return 0;
    }
}
