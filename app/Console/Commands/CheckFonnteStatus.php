<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FonnteService;

class CheckFonnteStatus extends Command
{
    protected $signature = 'fonnte:status';
    protected $description = 'Check Fonnte rate limit status';

    public function handle(FonnteService $fonnte)
    {
        $waitTime = $fonnte->getTimeUntilNextAllowed();
        
        if ($waitTime > 0) {
            $this->warn("⏳ Rate limit active!");
            $this->line("Wait time: {$waitTime} seconds");
            $this->line("Can send at: " . now()->addSeconds($waitTime)->format('H:i:s'));
        } else {
            $this->info("✅ Ready to send message!");
            $this->line("You can send WhatsApp notification now.");
        }

        return 0;
    }
}
