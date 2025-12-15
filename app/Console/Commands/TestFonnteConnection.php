<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FonnteService;

class TestFonnteConnection extends Command
{
    protected $signature = 'fonnte:test';
    protected $description = 'Test Fonnte WhatsApp connection';

    public function handle(FonnteService $fonnte)
    {
        $this->info('Testing Fonnte connection...');
        
        $result = $fonnte->testConnection();
        
        if ($result) {
            $this->info('✅ WhatsApp sent successfully!');
            $this->line(json_encode($result, JSON_PRETTY_PRINT));
        } else {
            $this->error('❌ Failed to send WhatsApp');
        }

        return 0;
    }
}
