<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class FonnteService
{
    protected $token;
    protected $adminPhone;
    protected $minInterval = 60; // Minimum 60 seconds between messages

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
        $this->adminPhone = config('services.fonnte.admin_phone');
    }

    /**
     * Check if we can send message (rate limiting)
     */
    private function canSendMessage()
    {
        $lastSentTime = Cache::get('fonnte_last_sent_time');
        
        if (!$lastSentTime) {
            return true; // First message, OK to send
        }

        $timeSinceLastMessage = now()->timestamp - $lastSentTime;
        
        if ($timeSinceLastMessage < $this->minInterval) {
            $waitTime = $this->minInterval - $timeSinceLastMessage;
            Log::warning('Fonnte Rate Limit: Too fast!', [
                'time_since_last' => $timeSinceLastMessage,
                'must_wait' => $waitTime . ' seconds'
            ]);
            return false;
        }

        return true;
    }

    /**
     * Record that we just sent a message
     */
    private function recordMessageSent()
    {
        Cache::put('fonnte_last_sent_time', now()->timestamp, now()->addHours(2));
    }

    /**
     * Send WhatsApp message via Fonnte
     */
    public function sendMessage($target, $message, $skipRateLimit = false)
    {
        try {
            // ✅ Check rate limit
            if (!$skipRateLimit && !$this->canSendMessage()) {
                Log::warning('Fonnte: Message blocked by rate limit', [
                    'target' => $target
                ]);
                return [
                    'status' => false,
                    'reason' => 'rate_limit',
                    'message' => 'Please wait before sending next message'
                ];
            }

            // ✅ Validate target format
            $target = $this->formatPhoneNumber($target);
            
            if (!$target) {
                Log::error('Fonnte Error: Invalid phone number format');
                return false;
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => $this->token
                ])
                ->post('https://api.fonnte.com/send', [
                    'target' => $target,
                    'message' => $message,
                    'countryCode' => '62'
                ]);

            Log::info('Fonnte WhatsApp Sent', [
                'target' => $target,
                'status' => $response->status(),
                'response' => $response->json()
            ]);

            // ✅ Check if response is successful
            if ($response->successful()) {
                $result = $response->json();
                
                // Check if Fonnte returned success
                if (isset($result['status']) && $result['status'] === true) {
                    // ✅ Record successful send
                    $this->recordMessageSent();
                    
                    Log::info('Fonnte: Message sent successfully', [
                        'target' => $target,
                        'next_allowed' => now()->addSeconds($this->minInterval)->format('H:i:s')
                    ]);
                    
                    return $result;
                }
            }

            Log::error('Fonnte Send Failed', [
                'target' => $target,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Fonnte Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Format phone number to international format
     */
    private function formatPhoneNumber($phone)
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If starts with 0, replace with 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // If doesn't start with 62, add it
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        // Validate length (Indonesian phone numbers: 10-13 digits after 62)
        if (strlen($phone) < 12 || strlen($phone) > 15) {
            return false;
        }

        return $phone;
    }

    /**
     * Send new order notification to admin
     */
    public function notifyNewOrder($transaction)
    {
        $message = "*🎉 NEW ORDER RECEIVED*\n\n";
        $message .= "Order ID: *{$transaction->transaction_code}*\n";
        $message .= "Customer: {$transaction->customer_name}\n";
        $message .= "Phone: {$transaction->customer_phone}\n\n";
        
        $message .= "*📦 Order Details:*\n";
        foreach ($transaction->details as $index => $detail) {
            $message .= ($index + 1) . ". {$detail->product_name}\n";
            $message .= "   Qty: {$detail->quantity} x Rp " . number_format($detail->price, 0, ',', '.') . "\n";
        }
        
        $message .= "\n*💰 Payment Summary:*\n";
        $message .= "Subtotal: Rp " . number_format($transaction->subtotal, 0, ',', '.') . "\n";
        $message .= "Shipping: Rp " . number_format($transaction->shipping_cost, 0, ',', '.') . "\n";
        $message .= "Total: *Rp " . number_format($transaction->total_amount, 0, ',', '.') . "*\n\n";
        
        $message .= "*📍 Shipping Address:*\n";
        $message .= "{$transaction->customer_address}\n\n";
        
        $message .= "Payment Status: ✅ *PAID*\n";
        $message .= "Order Date: " . $transaction->created_at->format('d M Y, H:i') . "\n";

        return $this->sendMessage($this->adminPhone, $message);
    }

    /**
     * Test connection with simple message
     */
    public function testConnection()
    {
        $testMessage = "✅ Test connection from Po Bakery\n\n";
        $testMessage .= "Time: " . now()->format('d M Y, H:i:s') . "\n";
        $testMessage .= "Status: Connected successfully!";

        // Skip rate limit for manual test command
        return $this->sendMessage($this->adminPhone, $testMessage, true);
    }

    /**
     * Get time until next message is allowed
     */
    public function getTimeUntilNextAllowed()
    {
        $lastSentTime = Cache::get('fonnte_last_sent_time');
        
        if (!$lastSentTime) {
            return 0; // Can send now
        }

        $timeSinceLastMessage = now()->timestamp - $lastSentTime;
        $waitTime = $this->minInterval - $timeSinceLastMessage;
        
        return $waitTime > 0 ? $waitTime : 0;
    }
}
