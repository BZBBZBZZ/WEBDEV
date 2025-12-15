<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Services\FonnteService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsAppNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $transaction;
    public $tries = 3; // Max 3 attempts
    public $timeout = 60; // 60 seconds timeout

    /**
     * Create a new job instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     */
    public function handle(FonnteService $fonnte): void
    {
        try {
            // Check rate limit
            $waitTime = $fonnte->getTimeUntilNextAllowed();
            
            if ($waitTime > 0) {
                // Still in cooldown, delay this job
                Log::info('WhatsApp job delayed due to rate limit', [
                    'transaction_code' => $this->transaction->transaction_code,
                    'delay_seconds' => $waitTime,
                    'retry_at' => now()->addSeconds($waitTime)->format('H:i:s')
                ]);
                
                // Release job back to queue with delay
                $this->release($waitTime);
                return;
            }

            // Load transaction details
            $this->transaction->load('details');

            // Send notification
            $result = $fonnte->notifyNewOrder($this->transaction);

            if ($result && (!is_array($result) || !isset($result['reason']))) {
                Log::info('WhatsApp notification sent successfully (via queue)', [
                    'transaction_code' => $this->transaction->transaction_code,
                    'attempts' => $this->attempts(),
                    'result' => $result
                ]);
            } else {
                Log::error('WhatsApp notification failed (via queue)', [
                    'transaction_code' => $this->transaction->transaction_code,
                    'attempts' => $this->attempts(),
                    'result' => $result
                ]);
                
                // Fail the job to retry later
                $this->fail();
            }

        } catch (\Exception $e) {
            Log::error('WhatsApp job error', [
                'transaction_code' => $this->transaction->transaction_code,
                'error' => $e->getMessage(),
                'attempts' => $this->attempts()
            ]);
            
            // If we have more attempts, release with delay
            if ($this->attempts() < $this->tries) {
                $this->release(30); // Wait 30 seconds before retry
            } else {
                $this->fail($e); // Max attempts reached
            }
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('WhatsApp job permanently failed', [
            'transaction_code' => $this->transaction->transaction_code,
            'error' => $exception->getMessage()
        ]);
    }
}
