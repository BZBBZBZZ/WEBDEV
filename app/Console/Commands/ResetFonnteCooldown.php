<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ResetFonnteCooldown extends Command
{
    protected $signature = 'fonnte:reset';
    protected $description = 'Reset Fonnte rate limit cooldown (Emergency only!)';

    public function handle()
    {
        if ($this->confirm('Are you sure you want to reset the cooldown? This should only be used in emergency!')) {
            Cache::forget('fonnte_last_sent_time');
            $this->info('✅ Cooldown reset successfully!');
            $this->warn('⚠️  You can now send message immediately.');
            $this->line('Please use wisely to avoid getting banned!');
        } else {
            $this->info('Operation cancelled.');
        }

        return 0;
    }
}
